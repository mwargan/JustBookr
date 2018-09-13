<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification implements ShouldQueue {
	use Queueable;

	protected $user;
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($user) {
		$this->user = $user;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return ['slack'];
	}

	/**
	 * Get the Slack representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return SlackMessage
	 */
	public function toSlack($notifiable) {
		$url = url('/user/' . $this->user->{'user-id'});
		return (new SlackMessage)
			->success()
			->content('A new user has joined.')
			->attachment(function ($attachment) use ($url) {
				$attachment->title('User ' . $this->user->{'user-id'}, $url)
					->author($this->user->name, url('/user/' . $this->user->{'user-id'}), $this->user->profilepic);
			});
	}
}
