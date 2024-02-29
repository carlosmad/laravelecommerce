<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Session;

class LogAuthenticatedUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {
        $user = $event->user;
        if($user->utype === 'ADM')
        {
            Session::put('utype' , 'ADM');

        }else {
            Session::put('utype' , 'USR');
        }
    }
}
