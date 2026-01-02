<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TeamActivityLog extends Notification implements ShouldQueue
{
    use Queueable;

    public $action;
    public $meta;

    /**
     * @param string $action (ex: 'team_created', 'member_joined')
     * @param array $meta (ex: ['team_name' => 'ShouCloud', 'target_user' => 'Bob'])
     */
    public function __construct(string $action, array $meta = [])
    {
        $this->action = $action;
        $this->meta = $meta;
    }

    public function via($notifiable)
    {
        return ['database']; // On logue uniquement en base
    }

    public function toDatabase($notifiable)
    {
        return array_merge([
            'action' => $this->action,
            'ip' => request()->ip(),
            'performed_at' => now(),
        ], $this->meta);
    }
}
