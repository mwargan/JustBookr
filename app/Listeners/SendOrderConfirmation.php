<?php

namespace App\Listeners;

use App\Events\OrderAccepted;
use App\Notifications\AcceptedOrder;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderConfirmation implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderAccepted $event
     *
     * @return void
     */
    public function handle(OrderAccepted $event)
    {
        $user = $event->order->buyer;
        $event->order->post->user->points()->create([
            'points' => '5',
            'action' => 'Accept',
        ]);
        $user->notify(new AcceptedOrder($event->order, $event->user));
    }
}
