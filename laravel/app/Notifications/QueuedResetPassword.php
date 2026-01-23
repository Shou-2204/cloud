<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedResetPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * Ici, on ajoute 'database' à la liste.
     * Laravel va donc : Envoyer le mail ET créer une ligne en base.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Ce que l'on stocke dans la base de données (le JSON).
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'security',
            'action' => 'reset_password',
            'ip_address' => request()->ip(), // On peut même loguer l'IP du demandeur !
            'sent_at' => now(),
        ];
    }
}
