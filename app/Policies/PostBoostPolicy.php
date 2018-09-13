<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\PostBoost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostBoostPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can create post boosts.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user, Post $post) {
		return $user->{'user-id'} === $post->{'user-id'};
	}

	/**
	 * Determine whether the user can create post boosts.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function skipPayment(User $user) {
		return false;
	}

	/**
	 * Determine whether the user can update the post boost.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\PostBoost  $postBoost
	 * @return mixed
	 */
	public function update(User $user, PostBoost $postBoost) {
		return false;
	}

	/**
	 * Determine whether the user can delete the post boost.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\PostBoost  $postBoost
	 * @return mixed
	 */
	public function delete(User $user, PostBoost $postBoost) {
		return $user->{'user-id'} === $postBoost->post->{'user-id'};
	}

	/**
	 * Determine whether the user can restore the post boost.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\PostBoost  $postBoost
	 * @return mixed
	 */
	public function restore(User $user, PostBoost $postBoost) {
		return $user->{'user-id'} === $postBoost->post->{'user-id'};
	}

	/**
	 * Determine whether the user can permanently delete the post boost.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\PostBoost  $postBoost
	 * @return mixed
	 */
	public function forceDelete(User $user, PostBoost $postBoost) {
		return false;
	}
}
