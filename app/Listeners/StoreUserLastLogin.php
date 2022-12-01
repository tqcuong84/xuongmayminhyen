<?php

namespace App\Listeners;

use App\Events\UserLastLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class StoreUserLastLogin
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
     * @param  \App\Events\UserLastLogin  $event
     * @return void
     */
    public function handle(UserLastLogin $event)
    {
        $user = $event->user;
        $user->last_login = Carbon::now();
        $user->save();
    }
}
