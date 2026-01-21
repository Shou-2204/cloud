<?php

declare(strict_types=1);

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkLogin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $url)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Connexion à votre compte ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth.magic-link-login',
        );
    }
}
