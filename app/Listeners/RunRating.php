<?php

namespace App\Listeners;

use App\Events\RatingAdded;

class RunRating
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
     * @param RatingAdded $event
     *
     * @return void
     */
    public function handle(RatingAdded $event)
    {
        //
    }
}
