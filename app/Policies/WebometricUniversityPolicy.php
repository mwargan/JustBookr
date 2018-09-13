<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WebometricUniversity;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebometricUniversityPolicy {
	use HandlesAuthorization;
	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can create webometric universities.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return false;
	}

	/**
	 * Determine whether the user can update the webometric university.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\WebometricUniversity  $webometricUniversity
	 * @return mixed
	 */
	public function update(User $user, WebometricUniversity $webometricUniversity) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the webometric university.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\WebometricUniversity  $webometricUniversity
	 * @return mixed
	 */
	public function forceDelete(User $user, WebometricUniversity $webometricUniversity) {
		return false;
	}
}
