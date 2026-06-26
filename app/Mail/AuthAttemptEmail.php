<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuthAttemptEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ipAddress;
    public $location;

    public function __construct($user, $ipAddress, $location = null)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->location = $location;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Security Alert - Failed Login Attempt',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.auth-attempt',
            with: [
                'user' => $this->user,
                'ipAddress' => $this->ipAddress,
                'location' => $this->location,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}