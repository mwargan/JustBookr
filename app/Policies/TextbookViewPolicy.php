<?php

namespace App\Policies;

use App\Models\TextbookView;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextbookViewPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can list all views.
     *
     * @param \App\Models\User $user
     * @param \App\Order       $order
     *
     * @return mixed
     */
    public function listAllTextbookViews(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the textbook view.
     *
     * @param \App\Models\User  $user
     * @param \App\TextbookView $textbookView
     *
     * @return mixed
     */
    public function view(User $user, TextbookView $textbookView)
    {
        return $user->{'user-id'} === $textbookView->{'user-id'};
    }

    /**
     * Determine whether the user can create textbook views.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the textbook view.
     *
     * @param \App\Models\User  $user
     * @param \App\TextbookView $textbookView
     *
     * @return mixed
     */
    public function forceDelete(User $user, TextbookView $textbookView)
    {
        return $user->{'user-id'} === $textbookView->{'user-id'};
    }
}
