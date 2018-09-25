<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCanceled extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $order;
    protected $user;

    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage());

        if ($notifiable->{'user-id'} === $this->user->{'user-id'}) {
            $message = $message->line('Unfortunately, you cancelled the order for '.$this->order->post->textbook->{'book-title'}.'.');
            $message = $message->line('Please note that cancelling orders negatively affects how high your posts rank, so try to keep cancellations to a minimum and instead reschedule whenever possible.');
        } else {
            $message = $message->line('Uh oh! '.$this->user->name.' had to cancel your order for '.$this->order->post->textbook->{'book-title'}.'. Find others selling the same book by clicking the button below!');
        }
        if ($notifiable->{'user-id'} === $this->order->{'user-id-buy'}) {
            $message = $message->action('See new posts for '.$this->order->post->textbook->{'book-title'}, url('textbook/'.$this->order->post->isbn));
        }
        if ($notifiable->{'user-id'} === $this->order->post->{'user-id'} && $this->user->{'user-id'} === $this->order->post->{'user-id'}) {
            $message = $message->line('If you have already sold one of your books outside of JustBookr, you should mark the post as sold so others can\'t buy it. Just go to your textbooks and press "Edit", then "Mark as sold".');
        } elseif ($notifiable->{'user-id'} === $this->order->post->{'user-id'}) {
            $message = $message->line('We have automatically made your post available again, but if you already sold it you should mark the post as sold so others can\'t buy it. Just go to your textbooks and press "Edit", then "Mark as sold".');
        }
        $message = $message->line('Thank you for using JustBookr!');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'The order for '.$this->order->post->textbook->{'book-title'}.' has been canceled.',
            'text'  => 'Canceled by '.$this->user->name,
        ];
    }
}
