<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Models\UserRating;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRatingPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the user rating.
     *
     * @param \App\Models\User $user
     * @param \App\UserRating  $userRating
     *
     * @return mixed
     */
    public function view(User $user, UserRating $userRating)
    {
        if ($user->{'user-id'} === $userRating->{'rated_by'} || $user->{'user-id'} === $userRating->{'user-id'}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create user ratings.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user, Order $order)
    {
        if ($user->{'user-id'} === $order->{'user-id-buy'} || $user->{'user-id'} === $order->{'user-id-sell'}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the user rating.
     *
     * @param \App\Models\User $user
     * @param \App\UserRating  $userRating
     *
     * @return mixed
     */
    public function update(User $user, UserRating $userRating)
    {
        if ($user->{'user-id'} === $userRating->{'rated_by'}) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the user rating.
     *
     * @param \App\Models\User $user
     * @param \App\UserRating  $userRating
     *
     * @return mixed
     */
    public function forceDelete(User $user, UserRating $userRating)
    {
        if ($user->{'user-id'} === $userRating->{'rated_by'}) {
            return true;
        }

        return false;
    }
}
