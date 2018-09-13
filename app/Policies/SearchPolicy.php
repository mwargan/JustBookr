<?php

namespace App\Policies;

use App\Models\Search;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SearchPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can list all searches.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Order  $order
	 * @return mixed
	 */
	public function listAllSearches(User $user) {
		return false;
	}

	/**
	 * Determine whether the user can view the search.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Search  $search
	 * @return mixed
	 */
	public function view(User $user, Search $search) {
		return $user->{'user-id'} === $search->{'user'};
	}

	/**
	 * Determine whether the user can create searches.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return true;
	}

	/**
	 * Determine whether the user can update the search.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Search  $search
	 * @return mixed
	 */
	public function update(User $user, Search $search) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the search.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Search  $search
	 * @return mixed
	 */
	public function forceDelete(User $user, Search $search) {
		return $user->{'user-id'} === $search->{'user'};
	}
}
