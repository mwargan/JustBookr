<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Notifications\OrderUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyBuyer implements ShouldQueue
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
     * @param OrderUpdated $event
     *
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $seller = $event->order->post->user;
        $buyer = $event->order->buyer;
        $seller->notify(new OrderUpdate($event->order, $event->user));
        $buyer->notify(new OrderUpdate($event->order, $event->user));
    }
}
