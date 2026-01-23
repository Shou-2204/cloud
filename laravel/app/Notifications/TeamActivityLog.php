<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TeamActivityLog extends Notification implements ShouldQueue
{
    use Queueable;

    public string $action;

    public array $meta;

    public string $ip; // On stocke l'IP ici

    public function __construct(string $action, array $meta = [], ?string $ip = null)
    {
        $this->action = $action;
        $this->meta = $meta;
        $this->ip = $ip ?? request()->ip() ?? 'CLI';
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return array_merge([
            'action' => $this->action,
            'ip' => $this->ip, // On utilise la propriété stockée
            'performed_at' => now(),
        ], $this->meta);
    }

    // Indispensable pour retrouver les logs dans Horizon
    public function tags(): array
    {
        $tags = ['activity_log', 'action:'.$this->action];

        // Si on a un ID de team ou user dans les métas, on l'ajoute aux tags Horizon
        if (isset($this->meta['team_id'])) {
            $tags[] = 'team:'.$this->meta['team_id'];
        }

        if (isset($this->meta['user_id'])) {
            $tags[] = 'user:'.$this->meta['user_id'];
        }

        return $tags;
    }
}
