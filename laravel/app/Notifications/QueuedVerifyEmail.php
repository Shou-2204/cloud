<?php

namespace App\Notifications;

use App\Mail\Auth\VerifyEmailMail;
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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \App\Mail\Auth\VerifyEmailMail
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new VerifyEmailMail($verificationUrl))
            ->to($notifiable->email);
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
