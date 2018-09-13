<?php

namespace App\Events;

use App\Models\Order;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderUpdated {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $order;
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order, User $user) {
		$this->order = $order;
		$this->user = $user;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	// public function broadcastOn() {
	// 	return new PrivateChannel('channel-name');
	// }
}
