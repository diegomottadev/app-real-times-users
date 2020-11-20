<?php

namespace App\Listeners;

use App\Events\UserChangeEvent;
use Illuminate\Auth\Events\Login;

class LoginUserListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        broadcast(new UserChangeEvent("{$event->user->name} is online", "success"));
    }
}
