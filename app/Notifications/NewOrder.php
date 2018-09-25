<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        return ['database', 'mail', 'slack'];
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
        return (new MailMessage())
            ->line("Congratulations! You've got a new order for one of your books.")
            ->action('Go to Inbox', url('inbox'))
            ->line('Thank you for using JustBookr!');
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
            'title' => "You've got a new order",
            'text'  => $this->order->buyer->name.' wants to buy '.$this->order->post->textbook->{'book-title'}.' from you',
        ];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $url = url('/post/'.$this->order->post->{'post-id'});

        return (new SlackMessage())
            ->success()
            ->content('A new order has been created.')
            ->attachment(function ($attachment) use ($url) {
                $attachment->title($this->order->post->textbook->{'book-title'}, $url)
                    ->author($this->order->buyer->name, url('/user/'.$this->order->buyer->{'user-id'}), $this->order->buyer->profilepic)
                    ->fields([
                        'Sold by'          => '<'.config('app.url').'/user/'.$this->order->post->user->{'user-id'}.'|'.$this->order->post->user->name.'>',
                        'Price'            => $this->order->post->price,
                        'Meeting time'     => \Carbon\Carbon::createFromTimeStamp($this->order->{'location-date'})->diffForHumans(),
                        'Meeting location' => $this->order->{'location-meet'},
                    ])
                    ->footer($this->order->post->university->{'uni-name'})
                    ->footerIcon($this->order->post->university->{'uni-logo'})
                    ->markdown(['text']);
            });
    }
}
