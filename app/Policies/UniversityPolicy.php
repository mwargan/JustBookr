<?php

namespace App\Policies;

use App\Models\University;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create Universities.
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
     * Determine whether the user can update the University.
     *
     * @param \App\Models\User $user
     * @param \App\University  $University
     *
     * @return mixed
     */
    public function update(User $user, University $University)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the University.
     *
     * @param \App\Models\User $user
     * @param \App\University  $University
     *
     * @return mixed
     */
    public function forceDelete(User $user, University $University)
    {
        return false;
    }
}
