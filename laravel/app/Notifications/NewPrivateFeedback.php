<?php

namespace App\Notifications;

use App\Models\TeamRating;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrivateFeedback extends Notification
{
    use Queueable;

    public TeamRating $rating;

    /**
     * Create a new notification instance.
     */
    public function __construct(TeamRating $rating)
    {
        $this->rating = $rating;
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
            'rating_id' => $this->rating->id,
            'team_id' => $this->rating->team_id,
            'rating_value' => $this->rating->rating,
            'message' => 'Nouveau feedback privé reçu (' . $this->rating->rating . '/5)',
        ];
    }
}
