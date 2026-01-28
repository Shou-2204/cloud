<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Summary email of ratings for a given period (on-demand).
 */
class RatingSummary extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $teamName,
        public Collection $ratings,
        public string $period,
        public float $averageRating,
        public int $positiveCount,
        public int $negativeCount,
        public Collection $feedbacks,
    ) {
    }

    public function envelope(): Envelope
    {
        $periodLabel = match ($this->period) {
            '24h' => 'dernières 24h',
            '7d' => '7 derniers jours',
            '30d' => '30 derniers jours',
            default => 'période sélectionnée',
        };

        return new Envelope(
            subject: "📋 Synthèse des avis ({$periodLabel}) - {$this->teamName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rating-summary-html',
        );
    }
}
