<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use App\Notifications\OrderCanceled as CanceledNotification;

class SendOrderCancelation {
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
	 * @param  OrderCanceled  $event
	 * @return void
	 */
	public function handle(OrderCanceled $event) {
		$event->order->buyer->notify(new CanceledNotification($event->order, $event->user));
		$event->order->post->user->notify(new CanceledNotification($event->order, $event->user));
	}
}
