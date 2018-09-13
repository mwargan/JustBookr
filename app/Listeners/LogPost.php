<?php

namespace App\Listeners;

use App\Events\PostAdded;
use App\Models\User;
use App\Notifications\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogPost implements ShouldQueue {
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
	 * @param  PostAdded  $event
	 * @return void
	 */
	public function handle(PostAdded $event) {
		$admin = User::findOrFail(config('app.admin_id'));
		$admin->notify(new NewPost($event->post));
	}
}
