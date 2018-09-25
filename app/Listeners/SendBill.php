<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\Bill;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBill implements ShouldQueue
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
     * @param OrderCreated $event
     *
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        // $event->order
        $user = $event->order->buyer;
        $user->points()->create([
            'points' => '4',
            'action' => 'Buy',
        ]);
        $user->notify(new Bill($event->order));
    }
}
