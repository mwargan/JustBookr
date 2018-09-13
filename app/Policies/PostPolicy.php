<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can create posts.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user, $isbn) {
		if (Post::where('user-id', '=', $user->{'user-id'})->where('uni-id', '=', $user->{'uni-id'})->where('isbn', '=', $isbn)->exists()) {
			return false;
		}
		return true;
	}

	/**
	 * Determine whether the user can update the post.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Post  $post
	 * @return mixed
	 */
	public function update(User $user, Post $post) {
		if ($post->status !== 1) {
			return false;
		}
		return $user->{'user-id'} === $post->{'user-id'};
	}

	/**
	 * Determine whether the user can mark the post as sold.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Post  $post
	 * @return mixed
	 */
	public function markSold(User $user, Post $post) {
		if ($post->status !== 1) {
			return false;
		}
		return $user->{'user-id'} === $post->{'user-id'};
	}

	/**
	 * Determine whether the user can mark the post as unsold.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Post  $post
	 * @return mixed
	 */
	public function markUnsold(User $user, Post $post) {
		if ($post->status !== 77) {
			return false;
		}
		return $user->{'user-id'} === $post->{'user-id'};
	}

	/**
	 * Determine whether the user can permanently delete the post.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Post  $post
	 * @return mixed
	 */
	public function forceDelete(User $user, Post $post) {
		if ($post->status !== 1) {
			return false;
		}
		return $user->{'user-id'} === $post->{'user-id'};
	}
}
