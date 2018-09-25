<?php

namespace App\Listeners;

use App\Events\OrderUpdated;

class NotifySeller
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
        //
    }
}
