<?php

namespace App\Policies;

use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}

	/**
	 * Determine whether the user can create countries.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return false;
	}

	/**
	 * Determine whether the user can update the country.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Country  $country
	 * @return mixed
	 */
	public function update(User $user, Country $country) {
		return false;
	}

}
