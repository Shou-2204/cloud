<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Ce qui sera stocké dans la table "notifications"
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'security',
            'action' => 'verify_email',
            'ip_address' => request()->ip(), // On logue l'IP par sécurité
            'sent_at' => now(),
        ];
    }
}
