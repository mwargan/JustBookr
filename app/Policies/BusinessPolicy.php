<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}
	/**
	 * Determine whether the user can view the business. DOESN'T WORK IN SHOW MEtHOD OF CONTROLLER
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Business  $business
	 * @return mixed
	 */
	public function view(User $user, Business $business) {
		return true;
	}

	/**
	 * Determine whether the user can create businesses.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return true;
	}

	/**
	 * Determine whether the user can update the business.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Business  $business
	 * @return mixed
	 */
	public function update(User $user, Business $business) {
		if ($user->businesses()->where('businesses.id', $business->id)->whereHas('users', function ($q) use ($user) {
			return $q->where('user_id', $user->{'user-id'})->where('is_admin', 1)->where('is_active', 1);
		})->exists()) {
			return true;
		}
		return false;
	}

	/**
	 * Determine whether the user can delete the business.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Business  $business
	 * @return mixed
	 */
	public function delete(User $user, Business $business) {
		if ($user->businesses()->where('businesses.id', $business->id)->whereHas('users', function ($q) use ($user) {
			return $q->where('user_id', $user->{'user-id'})->where('is_admin', 1)->where('is_active', 1);
		})->exists()) {
			return true;
		}
		return false;
	}

	/**
	 * Determine whether the user can restore the business.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Business  $business
	 * @return mixed
	 */
	public function restore(User $user, Business $business) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the business.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Business  $business
	 * @return mixed
	 */
	public function forceDelete(User $user, Business $business) {
		return false;
	}
}
