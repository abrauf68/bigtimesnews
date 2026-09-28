<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactMessageMail extends Mailable
{
    public array $data;
    public ?string $ip;

    public function __construct(array $data, ?string $ip = null)
    {
        $this->data = $data;
        $this->ip = $ip;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->data['email'], $this->data['name'])],
            subject: '[Contact] ' . $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_message',
            with: ['data' => $this->data, 'ip' => $this->ip],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
