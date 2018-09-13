<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can create tags.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return false;
	}

	/**
	 * Determine whether the user can update the tag.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Tag  $tag
	 * @return mixed
	 */
	public function update(User $user, Tag $tag) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the tag.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Tag  $tag
	 * @return mixed
	 */
	public function forceDelete(User $user, Tag $tag) {
		return false;
	}
}
