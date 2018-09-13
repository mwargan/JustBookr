<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderUpdate extends Notification {
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	protected $order;
	protected $user;

	public function __construct($order, $user) {
		$this->order = $order;
		$this->user = $user;
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
			->line('The order for ' . $this->order->post->textbook->{'book-title'} . ' has been updated by ' . $this->user->name . '. Please check JustBookr for new meeting times and places.')
			->action('See order', url('your-textbooks'))
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
			'title' => "The order for " . $this->order->post->textbook->{'book-title'} . " has been updated.",
			'text' => "Updated by " . $this->user->name,
		];
	}
}
