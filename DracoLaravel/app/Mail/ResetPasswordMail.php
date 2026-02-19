<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ResetPasswordMail extends Mailable
{
    public string $name;
    public string $url;
    public string $logo;

    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
        $this->logo = asset('media/imgs/logoDraco.png');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperación de contraseña - Draco'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.resetPassword',
            with: [
                'name' => $this->name,
                'url' => $this->url,
                'logo' => $this->logo,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
