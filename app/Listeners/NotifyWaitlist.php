<?php

namespace App\Listeners;

use App\Events\PostAdded;
use App\Models\User;
use App\Notifications\ExpectedPostAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyWaitlist implements ShouldQueue
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
        $post = $event->post;
        $isbn = $post->isbn;
        $user = $post['user-id'];
        $university = $post['uni-id'];
        $users = User::whereHas('bookNotifications', function ($q) use ($isbn, $university) {
            return $q->where('uni_id', '=', $university)->where('isbn', '=', $isbn);
        })->where('user-id', '!=', $user)->get();
        Notification::send($users, new ExpectedPostAdded($post));
    }
}
