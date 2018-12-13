<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Newsletter;

class LogRegisteredUser implements ShouldQueue
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
     * @param Registered $event
     *
     * @return void
     */
    public function handle(Registered $event)
    {
        if (config('app.env') == 'production') {
            Newsletter::subscribe($event->user->email, ['FNAME' => $event->user->name, 'LNAME' => $event->user->surname, 'USERID' => $event->user->{'user-id'}], 'JustBookr');
            $admin = User::findOrFail(config('app.admin_id'));
            $admin->notify(new NewUser($event->user));
        }
    }
}
