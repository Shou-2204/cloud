<?php

namespace App\Listeners;

use App\Notifications\LoginDetected;
use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // $event->user contient l'utilisateur qui vient de se connecter.
        // On lui attache la notification silencieuse.
        $event->user->notify(new LoginDetected());
    }
}
