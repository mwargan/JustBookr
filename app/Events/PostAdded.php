<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;

class PostAdded {
	use SerializesModels;
	public $post;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Post $post) {
		$this->post = $post;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	// public function broadcastOn()
	// {
	//     return new PrivateChannel('channel-name');
	// }
}
