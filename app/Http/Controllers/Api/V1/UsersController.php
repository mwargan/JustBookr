<?php

namespace App\Http\Controllers\Api\V1;

use App;
use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\User;
use Auth;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Newsletter;

class UsersController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request['order_by'] ?? 'name';
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '25';

        $active = $request['active'] ?? 'false';

        $uni = $request['university'] ?? null;

        $q = User::orderBy($orderBy, $orderSort);

        if ($active === 'true') {
            $q = $q->active();
        }

        if ($uni) {
            $q = $q->where('uni-id', '=', $uni);
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Display a listing of the users.
     *
     * @return Illuminate\View\View
     */
    public function notifications(Request $request)
    {
        $orderBy = $request['order_by'] ?? 'points_count';
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '25';

        $active = $request['all'] ?? 'false';

        if ($active == false) {
            $q = $request->user()->unreadNotifications();
        } else {
            $q = $request->user()->notifications();
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Store a new user in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        try {
            $request['password'] = chr(mt_rand(97, 122)) . substr(md5(time()), 1);
            $data = $this->getData($request);
            $user = User::create($data);

            return $user;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, User $user)
    {
        $user = $user->load('university.country');

        if ($request->user('api')) {
            if ($request->user('api')->can('seeEmail', $user)) {
                $user = $user->makeVisible(['email', 'surname']);
            }

            if ($request->user('api')->can('seePayment', $user)) {
                $user = $user->makeVisible(['card_brand', 'card_last_four', 'stripe_id', 'trial_ends_at']);
            }
        }

        return $user;
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function me(Request $request)
    {
        return $request->user()->load('university.country', 'businesses.stands')->append('unread_orders')->makeVisible(['email', 'surname', 'card_brand', 'card_last_four', 'stripe_id', 'trial_ends_at']);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function postViews(Request $request, User $user)
    {
        if (!$user->name && $request->user('api')) {
            $user = $request->user('api');
        } elseif (!$user->name) {
            return response()->json(['errors' => ['user' => 'There was no user provided.']], 422);
        }
        $this->authorize('update', $user);
        // getting all of the users available posts
        $user = $user->posts()->available()->withCount([
            // from the related table views
            'views' => function ($q) {
                // limit results to 'in the past month'
                $q->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 MONTH)')

                    ->whereRaw('`date-viewed` >= posts.date')

                    ->where(function ($query) {
                        // limit to on-place, or not
                        $query->whereRaw('`uni-viewed` = posts.`uni-id`')->orWhereNull('uni-viewed');
                    })
                    ->where(function ($query) {
                        // limit to on-place, or not
                        $query->whereRaw('`user-id` != posts.`user-id`')->orWhereNull('user-id');
                    });
            },
        ])->distinct()->get()->unique('isbn')->pluck('views_count', 'isbn');
        if ($request->query('sum', 'true') === 'true') {
            $user = $user->sum();
        }

        return response()->json(['views_past_month' => $user]);
    }

    /**
     * Display the average time to reply.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function timeToReply(Request $request, User $user)
    {
        if (!$user->name && $request->user('api')) {
            $user = $request->user('api');
        } elseif (!$user->name) {
            return response()->json(['errors' => ['user' => 'There was no user provided.']], 422);
        }

        return response()->json($user->timeToReply);
    }

    /**
     * Update the specified user in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);

        try {

            $data = $this->getData($request);
            $user->update($data);

            if ($data['email'] && $data['email'] !== $user->email) {
                Newsletter::updateEmailAddress($user->email, $data['email']);
            }
            if (isset($data['newsletter']) && $data['newsletter'] == 1) {
                Newsletter::subscribeOrUpdate($user->email, ['uni-id' => $user->{'uni-id'}]);
            } elseif (isset($data['newsletter']) && !$data['newsletter']) {
                Newsletter::unsubscribe($user->email);
            }

            return response()->json(['data' => $user->load('university.country')]);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    public function updateCard(Request $request)
    {
        try {
            $stripeToken = $request->input('card_token', null);
            $user = $request->user('api');
            if ($user->stripe_id) {
                $user->updateCard($stripeToken);
            } else {
                $user->createAsStripeCustomer($stripeToken);
            }

            return $user->load('university.country')->makeVisible(['card_brand', 'card_last_four', 'stripe_id', 'trial_ends_at']);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Update the specified user in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function setUniversity(Request $request)
    {
        try {
            $uni = University::findOrFail($request['university']);
            $user = Auth::user();
            $user->{'uni-id'} = $uni->{'uni-id'};
            $user->save();
            if (config('app.env') == 'production') {
                Newsletter::subscribeOrUpdate($user->email, ['uni-id' => $user->{'uni-id'}]);
            }

            return $user->load('university.country');
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    public function setProfilePicture(Request $request)
    {
        try {
            $user = $request->user('api');
            $link = Storage::putFile('images/Uploads/users/' . $user->{'user-id'} . '/images/avatar', $request->file('image'), 'public');
            $user->profilepic = Storage::url($link);
            $user->save();

            return $user->load('university.country');
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified user from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(User $user)
    {
        $this->authorize('forceDelete', $user);

        try {
            $user->delete();

            return response()->json(['Resource deleted']);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     *
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:64',
            'surname' => 'required|string|min:1|max:64',
            'aboutme' => 'nullable|string|min:0|max:8388607',
            'username' => 'nullable|unique:users,username|string|min:0|max:259',
            'password' => 'sometimes|required|string|min:1|max:8388607',
            'email' => 'required|email|unique:users,email,' . request('user.user-id') . ',user-id',
            'uni-id' => 'nullable|exists:webometric_universities,uni-id',
            'country' => 'nullable|exists:countries,name|string|min:0|max:20',
            'city' => 'nullable|string|min:0|max:64',
            'address' => 'nullable|string|min:0|max:259',
            'user-tel' => 'nullable|string|unique:users,user-tel|min:0|max:20',
            'userlevel' => 'boolean',
            'profilepic' => 'nullable|url',
            'image' => 'image',
            'newsletter' => 'sometimes|boolean',
        ];

        $data = $request->validate($rules);

        $data['userlevel'] = $request->has('userlevel');

        return $data;
    }
}
