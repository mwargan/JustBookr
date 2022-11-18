<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function listAllOrders(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $user->{'user-id'} === $order->{'user-id-buy'} || $user->{'user-id'} === $order->{'user-id-sell'};
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user, Post $post)
    {
        if ($post->{'uni-id'} !== $user->{'uni-id'}) {
            return false;
        }

        if ($post->status === 1 && $post->{'user-id'} !== $user->{'user-id'} && $user->points >= 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        if ($user->{'user-id'} === $order->{'user-id-buy'} || $user->{'user-id'} === $order->{'user-id-sell'}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can accept the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function accept(User $user, Order $order)
    {
        if ($user->{'user-id'} === $order->{'user-id-sell'}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        if ($user->{'user-id'} === $order->{'user-id-buy'} || $user->{'user-id'} === $order->{'user-id-sell'}) {
            return true;
        }

        return false;
    }
}
