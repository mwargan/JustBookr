<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\User        $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->{'user-id'} === $model->{'user-id'};
    }

    /**
     * Determine whether the user see the models email.
     *
     * @param \App\Models\User $user
     * @param \App\User        $model
     *
     * @return mixed
     */
    public function seeEmail(User $user, User $model)
    {
        return $user->{'user-id'} === $model->{'user-id'};
    }

    /**
     * Determine whether the user can see the models payment details.
     *
     * @param \App\Models\User $user
     * @param \App\User        $model
     *
     * @return mixed
     */
    public function seePayment(User $user, User $model)
    {
        return $user->{'user-id'} === $model->{'user-id'};
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\User        $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->{'user-id'} === $model->{'user-id'};
    }
}
