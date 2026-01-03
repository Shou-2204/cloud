<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LoginDetected extends Notification implements ShouldQueue
{
    use Queueable;

    public $details;

    // On capture les infos dès la création de la notification
    public function __construct()
    {
        $this->details = [
            'ip' => request()->ip(),
            'device' => request()->userAgent(),
            'email' => auth()->user()?->email, // Optionnel mais rassurant
        ];
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'action' => 'login_successful',
            'ip' => $this->details['ip'],
            'device' => $this->details['device'],
            'user_email' => $this->details['email'],
        ];
    }
}