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
        $user->notify(new LoginDetected(
                        $user,
                        request()->ip(),          // On capture l'IP ici, tant qu'on est dans la requête Web
                        request()->userAgent()    // Idem pour le User Agent
                    ));
    }
}
