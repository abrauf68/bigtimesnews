<?php

namespace App\Mail;

use App\Models\SocialPlatformAccount;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SocialAccountUnhealthyMail extends Mailable
{
    public function __construct(public SocialPlatformAccount $account)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Action needed] ' . $this->account->platformEnum()->label() . ' social account needs reconnecting',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.social_account_unhealthy',
            with: ['account' => $this->account],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
