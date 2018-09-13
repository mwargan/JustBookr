<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpectedPostAdded extends Notification implements ShouldQueue {
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
		return ['mail', 'database'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable) {
		return (new MailMessage)
			->subject("There's a new offer for " . $this->post->textbook->{'book-title'})
			->line("A new post for " . $this->post->textbook->{'book-title'} . " from " . $this->post->user->name . " for " . $this->post->price . " has been added.")
			->action('See the offer', url('textbook/' . $this->post->isbn))
			->line('If you\'d like, you can turn off these notifications by going into this books\' info page.')
			->line('Thank you for using JustBookr!');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable) {
		return [
			'title' => "A new post for " . $this->post->textbook->{'book-title'} . " for " . $this->post->price . " has been added.",
			'text' => "By " . $this->post->user->name,
			'link' => "/textbook/" . $this->post->isbn,
		];
	}
}