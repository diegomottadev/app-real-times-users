<?php

namespace App\Listeners;

use App\Events\UserChangeEvent;
use Illuminate\Auth\Events\Logout;


class LogoutUserListener
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
    public function handle(Logout $event)
    {
        //
        broadcast(new UserChangeEvent("{$event->user->name} is offline", "danger"));

    }
}
