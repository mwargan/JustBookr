<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Login  $event
	 * @return void
	 */
	public function handle(Login $event) {
		$event->user->points()->create([
			'points' => "1",
			'action' => "Log in",
		]);
		$event->user->{'last-login'} = Carbon::now();
		$event->user->{'last_ip_access'} = request()->ip();
		$event->user->save();
	}
}
