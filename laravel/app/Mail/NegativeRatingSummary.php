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
 * Summary email of negative ratings for a given period.
 */
class NegativeRatingSummary extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $teamName,
        public Collection $ratings,
        public string $period,
    ) {}

    public function envelope(): Envelope
    {
        $periodLabel = match ($this->period) {
            '24h' => 'dernières 24h',
            '7d' => '7 derniers jours',
            '30d' => '30 derniers jours',
            default => 'période sélectionnée',
        };

        return new Envelope(
            subject: "📋 Synthèse des avis négatifs ({$periodLabel}) - {$this->teamName}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.negative-rating-summary-html',
        );
    }
}
