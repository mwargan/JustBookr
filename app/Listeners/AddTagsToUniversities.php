<?php

namespace App\Listeners;

use App\Events\TagAdded;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddTagsToUniversities implements ShouldQueue
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
     * @param TagAdded $event
     *
     * @return void
     */
    public function handle(TagAdded $event)
    {
        //
    }
}
