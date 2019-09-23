<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessStand;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class BusinessStandsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'optimizeImages'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the business stands.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request->input('order_by', 'posts_count');
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '50';

        $available = $request['available'] ?? 'false';
        $active = $request['active'] ?? 'false';

        $business = $request->input('business');

        $q = BusinessStand::with('business', 'university')->withCount('posts')->orderBy($orderBy, $orderSort);

        if ($business) {
            $q->where('business_id', $business);
        }
        if ($active === 'true') {
            $q->active();
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Store a new business stand in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request['is_active'] = 1;

        $data = $this->getData($request);

        $this->authorize('create', [BusinessStand::class, $data['business_id']]);

        try {
            $user = $request->user('api');

            $creditCardToken = $request->input('card_token', null);

            $post = BusinessStand::create($data);

            $plan = config('services.stripe.plan');

            if ($user->subscribedToPlan($plan, 'Business Stand')) {
                $user->subscription('Business Stand')->noProrate()->incrementQuantity();
            } elseif (! $creditCardToken) {
                $user->newSubscription('Business Stand', $plan)->create();
            } elseif ($creditCardToken) {
                $user->newSubscription('Business Stand', $plan)->create($creditCardToken);
            } else {
                return response()->json(['errors' => 'Invalid payment proccess'], 422);
            }
            //return false;

            return $post;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Activate the stand.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function activate(BusinessStand $stand, Request $request)
    {
        $this->authorize('general', $stand);

        try {
            if ($stand->is_active) {
                return $stand;
            }
            $user = $request->user('api');

            $stand->is_active = 1;
            $user->subscription('Business Stand')->noProrate()->incrementQuantity();
            $stand->save();

            return $stand;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Deactivate the stand.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function deactivate(BusinessStand $stand, Request $request)
    {
        $this->authorize('general', $stand);

        try {
            if (! $stand->is_active) {
                return $stand;
            }
            $user = $request->user('api');

            $stand->is_active = 0;
            $user->subscription('Business Stand')->noProrate()->decrementQuantity();
            $stand->save();

            return $stand;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified business stand.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $stand = BusinessStand::with('business', 'university', 'posts.textbook')->findOrFail($id);

        return $stand;
    }

    /**
     * Update the specified business stand in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(BusinessStand $stand, Request $request)
    {
        $this->authorize('general', $stand);

        try {
            $data = $this->getData($request);

            $stand = BusinessStand::findOrFail($id);

            $stand->update($data);

            return $stand;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified business stand from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(BusinessStand $stand)
    {
        $this->authorize('general', $stand);

        try {
            $stand = BusinessStand::findOrFail($id);
            $stand->delete();

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
            'business_id' => 'required|exists:businesses,id',
            'uni_id'      => 'required|exists:webometric_universities,uni-id',
            'stand_text'  => 'string|min:15|nullable',
            'location'    => 'string|min:3|nullable',
            'is_active'   => 'boolean',

        ];

        $data = $request->validate($rules);

        return $data;
    }
}
