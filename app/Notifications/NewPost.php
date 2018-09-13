<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification implements ShouldQueue {
	use Queueable;

	protected $post;
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($post) {
		$this->post = $post;
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
		$url = url('/post/' . $this->post->{'post-id'});
		return (new SlackMessage)
			->success()
			->content('A new post has been created.')
			->attachment(function ($attachment) use ($url) {
				$attachment->title('Post ' . $this->post->{'post-id'}, $url)
					->author($this->post->user->name, url('/user/' . $this->post->{'user-id'}), $this->post->user->profilepic)
					->fields([
						'Book' => '<' . config('app.url') . '/textbook/' . $this->post->isbn . '|' . $this->post->textbook->{'book-title'} . '>',
						'Price' => $this->post->price,
					])
					->footer($this->post->university->{'uni-name'})
					->footerIcon($this->post->university->{'uni-logo'})
					->markdown(['text']);
			});
	}
}
