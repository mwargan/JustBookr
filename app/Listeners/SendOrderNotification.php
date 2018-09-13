<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\NewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderNotification implements ShouldQueue {
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
	 * @param  OrderCreated  $event
	 * @return void
	 */
	public function handle(OrderCreated $event) {
		// $event->order
		$user = $event->order->post->user;
		$user->notify(new NewOrder($event->order));
	}
}
