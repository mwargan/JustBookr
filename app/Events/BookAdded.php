<?php

namespace App\Events;

use App\Models\Textbook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Textbook $book)
    {
        $this->book = $book;
    }

    /*
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
