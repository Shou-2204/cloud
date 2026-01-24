<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionChanged extends Notification
{
    use Queueable;

    public string $planName;

    public string $type;

    /**
     * Create a new notification instance.
     *
     * @param  string  $planName  The name of the plan
     * @param  string  $type  One of: 'subscribed', 'upgraded', 'downgraded', 'cancelled', 'resumed'
     */
    public function __construct(string $planName, string $type = 'subscribed')
    {
        $this->planName = $planName;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $messages = [
            'subscribed' => "Bienvenue ! Vous êtes maintenant abonné à l'offre {$this->planName}",
            'upgraded' => "Votre abonnement a été mis à niveau vers {$this->planName}",
            'downgraded' => "Votre abonnement a été modifié vers {$this->planName}",
            'cancelled' => "Votre abonnement {$this->planName} a été annulé",
            'resumed' => "Votre abonnement {$this->planName} a été réactivé",
        ];

        return [
            'plan_name' => $this->planName,
            'type' => $this->type,
            'message' => $messages[$this->type] ?? 'Modification de votre abonnement',
            'url' => route('subscription.index'),
        ];
    }
}
