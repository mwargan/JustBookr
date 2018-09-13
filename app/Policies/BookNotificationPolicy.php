<?php

namespace App\Policies;

use App\Models\BookNotification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookNotificationPolicy {
	use HandlesAuthorization;

	public function before($user, $ability) {
		if ($user->isSuperAdmin()) {
			return true;
		}
	}
	/**
	 * Determine whether the user can view the book notification.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\BookNotification  $bookNotification
	 * @return mixed
	 */
	public function view(User $user, BookNotification $bookNotification) {
		return $user->{'user-id'} === $bookNotification->user_id;
	}

	/**
	 * Determine whether the user can create book notifications.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return true;
	}

	/**
	 * Determine whether the user can delete the book notification.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\BookNotification  $bookNotification
	 * @return mixed
	 */
	public function delete(User $user, BookNotification $bookNotification) {
		return $user->{'user-id'} === $bookNotification->user_id;
	}

	/**
	 * Determine whether the user can restore the book notification.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\BookNotification  $bookNotification
	 * @return mixed
	 */
	public function restore(User $user, BookNotification $bookNotification) {
		return false;
	}

	/**
	 * Determine whether the user can permanently delete the book notification.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\BookNotification  $bookNotification
	 * @return mixed
	 */
	public function forceDelete(User $user, BookNotification $bookNotification) {
		return false;
	}
}
