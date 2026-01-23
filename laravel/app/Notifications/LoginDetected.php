<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LoginDetected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $ip,
        public string $userAgent
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'action' => 'login_successful',
            'ip' => $this->ip,
            'device' => $this->userAgent,
            'user_email' => $this->user->email,
        ];
    }

    public function tags(): array
    {
        return ['login', 'user:'.$this->user->id];
    }
}
