<?php

namespace App\Policies;

use App\Models\StandPost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StandPostPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create stand posts.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user, $stand_id)
    {
        if ($user->businesses()->whereHas('stands', function ($q) use ($stand_id) {
            return $q->active()->where('id', $stand_id);
        })->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the stand post.
     *
     * @param \App\Models\User      $user
     * @param \App\Models\StandPost $standPost
     *
     * @return mixed
     */
    public function general(User $user, StandPost $post)
    {
        if ($user->businesses()->whereHas('stands', function ($q) use ($post) {
            return $q->active()->where('id', $post->stand_id);
        })->exists()) {
            return true;
        }

        // Alternate check
        // if ($post->stand()->whereHas('business.users', function ($q) use ($user) {
        // 	return $q->where('user-id', $user->{'user-id'});
        // })->exists()) {
        // 	return true;
        // }
        return false;
    }
}
