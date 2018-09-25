<?php

namespace App\Listeners;

use App\Events\PostAdded;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserPoints implements ShouldQueue
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
     * @param PostAdded $event
     *
     * @return void
     */
    public function handle(PostAdded $event)
    {
        $event->post->user->points()->create([
            'points' => '2',
            'action' => 'Post',
        ]);
    }
}
