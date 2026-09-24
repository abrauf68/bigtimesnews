<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AiBlogDraftsReadyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emailSettings;

    /**
     * @param Collection $completed Posts (App\Models\Post) generated successfully today
     * @param Collection $failed AiBlogTopic rows that failed today
     */
    public function __construct(public Collection $completed, public Collection $failed, public bool $autoPublished)
    {
        $this->emailSettings = EmailSetting::first();
    }

    public function envelope(): Envelope
    {
        $count = $this->completed->count();
        $subject = $this->autoPublished
            ? "{$count} AI-generated blog post(s) published today"
            : "{$count} AI-generated blog post(s) ready to review";

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ai_blog_drafts_ready',
            with: [
                'completed' => $this->completed,
                'failed' => $this->failed,
                'autoPublished' => $this->autoPublished,
                'emailSettings' => $this->emailSettings,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
