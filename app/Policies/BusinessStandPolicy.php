<?php

namespace App\Policies;

use App\Models\BusinessStand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessStandPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create business stands.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user, $business_id)
    {
        if ($user->businesses()->where('businesses.id', $business_id)->whereHas('users', function ($q) use ($user) {
            return $q->where('user_id', $user->{'user-id'})->where('is_admin', 1)->where('is_active', 1);
        })->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create business stands.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function general(User $user, BusinessStand $stand)
    {
        if ($user->businesses()->where('businesses.id', $stand->business_id)->whereHas('users', function ($q) use ($user) {
            return $q->where('user_id', $user->{'user-id'})->where('is_admin', 1)->where('is_active', 1);
        })->exists()) {
            return true;
        }

        return false;
    }
}
