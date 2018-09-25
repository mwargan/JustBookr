<?php

namespace App\Listeners;

use App\Events\BookAdded;
use App\Models\Tag;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddTags implements ShouldQueue
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
     * @param BookAdded $event
     *
     * @return void
     */
    public function handle(BookAdded $event)
    {
        foreach (Tag::cursor() as $tag) {
            if (stripos($event->book->{'book-title'}, $tag['t-data']) !== false) {
                $event->book->textbookTags()->create([
                    'isbn'   => $event->book->isbn,
                    'tag-id' => $tag['tag-id'],
                ]);
            }
        }
    }
}
