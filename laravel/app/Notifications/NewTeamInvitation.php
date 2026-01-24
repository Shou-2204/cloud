<?php

namespace App\Notifications;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTeamInvitation extends Notification
{
    use Queueable;

    public Team $team;

    public string $email;

    /**
     * Create a new notification instance.
     */
    public function __construct(Team $team, string $email)
    {
        $this->team = $team;
        $this->email = $email;
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
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'email' => $this->email,
            'message' => "Nouvelle invitation envoyée à {$this->email}",
            'url' => route('teams.show', $this->team),
        ];
    }
}
