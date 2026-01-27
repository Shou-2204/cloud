<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BugReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $description,
        public string $reportedUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Bug Report] ' . config('app.name') . ' - ' . $this->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bug-report',
            with: [
                'user' => $this->user,
                'description' => $this->description,
                'reportedUrl' => $this->reportedUrl,
                'reportedAt' => now(),
            ],
        );
    }
}
