<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
//use App\Models\RatedBy;
use App\Models\Order;
use App\Models\User;
use App\Models\UserRating;
use Auth;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class UserRatingsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the user ratings.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return UserRating::with('user', 'ratedby')->paginate(25);
    }

    /**
     * Store a new user rating in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $order = Order::findOrFail($request->{'connect-id'});

        $this->authorize('create', [UserRating::class, $order]);

        try {
            if (Auth::user()->{'user-id'} !== $order->{'user-id-buy'} && Auth::user()->{'user-id'} !== $order->{'user-id-sell'}) {
                return response()->json('Unauthorized waa', 403);
            }

            if (Auth::user()->{'user-id'} === $order->{'user-id-buy'}) {
                $user_rated = $order->{'user-id-sell'};
            } elseif (Auth::user()->{'user-id'} === $order->{'user-id-sell'}) {
                $user_rated = $order->{'user-id-buy'};
            } else {
                return response()->json('Unauthorized waa', 403);
            }

            $request->request->add(['rated_by' => Auth::user()->{'user-id'}]);
            $request->request->add(['user-id' => $user_rated]);

            $data = $this->getData($request);

            $rating = UserRating::firstOrCreate(
                ['connect-id' => $data['connect-id'], 'rated_by' => $data['rated_by']], ['rating' => $data['rating'], 'comment' => $data['comment'], 'user-id' => $data['user-id'], 'status' => 0]
            );

            return $rating;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified user rating.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(UserRating $userRating)
    {
        return $userRating->with('user', 'ratedby')->findOrFail($id);
    }

    /**
     * Update the specified user rating in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(UserRating $userRating, Request $request)
    {
        $this->authorize('update', $userRating);

        try {
            $data = $this->getData($request);

            return $userRating->update($data);
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified user rating from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(UserRating $userRating)
    {
        $this->authorize('forceDelete', $userRating);

        try {
            $userRating->delete();

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
            'user-id'    => 'nullable|numeric|exists:users,user-id',
            'rating'     => 'required|numeric|min:0|max:5',
            'timestamp'  => 'nullable|date_format:j/n/Y g:i A',
            'rated_by'   => 'nullable|numeric|exists:users,user-id',
            'comment'    => 'nullable',
            'connect-id' => 'required|numeric|min:0|max:2147483647|exists:connected_users,connect-id',
            'status'     => 'nullable|numeric|min:0|max:1',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}
