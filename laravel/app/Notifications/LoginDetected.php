<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LoginDetected extends Notification implements ShouldQueue
{
    use Queueable;

    // On utilise UNIQUEMENT le canal database (pas de mail)
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'action' => 'login_successful',
            'ip' => request()->ip(),
            'device' => request()->userAgent(), // Utile pour savoir si c'est iPhone, Chrome, etc.
        ];
    }
}
