<?php

namespace App\Policies;

use App\Models\Textbook;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextbookPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create textbooks.
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
     * Determine whether the user can update the textbook.
     *
     * @param \App\Models\User $user
     * @param \App\Textbook    $textbook
     *
     * @return mixed
     */
    public function update(User $user, Textbook $textbook)
    {
        return false;
    }
}
