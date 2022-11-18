<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use ExceptionHelper;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the orders.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orderBy = $request['order_by'] ?? 'connect-id';
        $orderSort = $request['order_sort'] ?? 'desc';

        $paginate = $request['paginate'] ?? 'yes';
        $perPage = $request['per_page'] ?? '50';

        $replied = $request['replied'] ?? 'null';

        $location = $request['location'];
        $buyer = $request['buyer'];
        $seller = $request['seller'];
        $user = $request['user'];
        $current_user = $request->user('api');

        $q = Order::orderBy($orderBy, $orderSort)->with('buyer', 'post.user', 'post.textbook', 'ratings');

        if ($replied === 'true') {
            $q = $q->replied();
        }

        if ($replied === 'false') {
            $q = $q->unreplied();
        }

        if ($user && $current_user->can('listAllOrders', Order::class)) {
            $q = $q->where(function ($query) use ($user) {
                return $query->where('user-id-buy', '=', $user)->orWhere('user-id-sell', '=', $user);
            });
        } elseif ($current_user->canNot('listAllOrders', Order::class)) {
            $q = $q->where(function ($query) use ($current_user) {
                return $query->where('user-id-buy', '=', $current_user->{'user-id'})->orWhere('user-id-sell', '=', $current_user->{'user-id'});
            });
        }

        if ($location) {
            $q = $q->where('location-meet', '=', $location);
        }

        if ($buyer) {
            $q = $q->where('user-id-buy', '=', $buyer);
        }

        if ($seller) {
            $q->whereHas('post', function ($q) use ($seller) {
                return $q->where('user-id', $seller);
            });
        }

        if ($paginate === 'yes') {
            return $q->paginate($perPage);
        }

        return $q->get();
    }

    /**
     * Store a new order in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $post = Post::findOrFail($request['post-id']);

        $this->authorize('create', [Order::class, $post]);

        try {
            $request['user-id-buy'] = $request->input('user-id-buy', $request->user()->{'user-id'});

            $data = $this->getData($request);

            $order = Order::create($data);

            $post->status = 0;

            $post->save();

            $data = $order->load('post.user', 'buyer', 'post.textbook');

            event(new OrderCreated($data));

            return $data;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::with('buyer', 'post.user', 'post.textbook', 'ratings')->findOrFail($id);

        $this->authorize('view', [Order::class, $order]);

        return $order;
    }

    /**
     * Update the specified order in the storage.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Order $order, Request $request)
    {
        $this->authorize('update', $order);

        try {
            $request['user-id-sell'] = $order->post->{'user-id'};
            $request['user-id-buy'] = $order['user-id-buy'];
            $request['post-id'] = $order['post-id'];

            $request['location-meet'] = request('location-meet', $order['location-meet']);
            $request['location-date'] = request('location-date', $order['location-date']);

            $data = $this->getData($request);

            $order->update($data);

            event(new OrderUpdated($order->load('post.user', 'buyer', 'post.textbook'), $request->user('api')));

            return $order;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Accept/reply to order.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function accept(Order $order, Request $request)
    {
        $this->authorize('accept', $order);

        try {
            $order->replied = Carbon::now();
            $order->save();

            event(new OrderAccepted($order->load('buyer', 'post.textbook'), $request->user('api')));

            return $order;
        } catch (Exception $exception) {
            return ExceptionHelper::handleError($exception, $request);
        }
    }

    /**
     * Remove the specified order from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Order $order, Request $request)
    {
        $this->authorize('forceDelete', $order);

        try {
            $post = $order->post;

            if ($request->user('api')->{'user-id'} === $order->{'user-id-buy'}) {
                $post->status = 1;
            } else {
                $post->status = 78;
            }

            $post->save();

            //Call event first, after delete $order won't be available
            event(new OrderCanceled($order->load('post.user', 'buyer', 'post.textbook'), $request->user('api')));

            $order->delete();

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
            'user-id-sell'  => 'sometimes',
            'user-id-buy'   => 'required|exists:users,user-id',
            'post-id'       => 'required|unique:connected_users,post-id,' . request('post-id') . ',post-id',
            'comment'       => 'nullable|string|max:500',
            'timestamp'     => 'nullable|date_format:j/n/Y g:i A',
            'location-meet' => 'required|string|min:1|max:150',
            'location-date' => 'required|date_format:U',
            'location-time' => 'nullable|string|min:0|max:20',
            'replied'       => 'nullable|date_format:j/n/Y g:i A',

        ];

        //$request->validate($rules);
        $data = $this->validate($request, $rules);

        return $data;
    }

    public function rules()
    {
        $user = User::find($this->users);

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return [
                        'user.name.first' => 'required',
                        'user.name.last'  => 'required',
                        'user.email'      => 'required|email|unique:users,email',
                        'user.password'   => 'required|confirmed',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'user.name.first' => 'required',
                        'user.name.last'  => 'required',
                        'user.email'      => 'required|email|unique:users,email,' . $user->id,
                        'user.password'   => 'required|confirmed',
                    ];
                }
            default:
                break;
        }
    }
}
