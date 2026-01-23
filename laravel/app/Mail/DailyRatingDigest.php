<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Daily digest email summarizing ratings received.
 */
class DailyRatingDigest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $teamName,
        public Collection $ratings,
        public float $averageRating,
        public int $positiveCount,
        public int $negativeCount,
        public Collection $negativeFeedbacks,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "📊 Résumé quotidien des avis - {$this->teamName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily-rating-digest',
        );
    }
}
