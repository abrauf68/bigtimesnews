<?php

namespace App\Console\Commands;

use App\Mail\AiBlogDraftsReadyMail;
use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAiBlogSummary extends Command
{
    protected $signature = 'ai-blog:send-summary';

    protected $description = 'Emails the admin once today\'s AI blog batch has finished generating (success + failures).';

    public function handle(): int
    {
        $settings = AiBlogSetting::first();

        if (!$settings || !$settings->is_enabled || !$settings->notify_admin) {
            return self::SUCCESS;
        }

        $today = now()->toDateString();

        if (!$settings->last_run_date || $settings->last_run_date->toDateString() !== $today) {
            return self::SUCCESS; // no batch dispatched today
        }

        if ($settings->last_summary_sent_date && $settings->last_summary_sent_date->toDateString() === $today) {
            return self::SUCCESS; // already emailed for today's batch
        }

        $todaysTopics = AiBlogTopic::today()->get();

        if ($todaysTopics->isEmpty()) {
            return self::SUCCESS;
        }

        $stillRunning = $todaysTopics->whereIn('status', ['pending', 'generating'])->count();
        if ($stillRunning > 0) {
            return self::SUCCESS; // wait for the queue to finish the rest
        }

        $completed = $todaysTopics->where('status', 'completed')->load('post.category');
        $failed = $todaysTopics->where('status', 'failed');

        $recipient = $settings->resolvedAdminEmail();
        if (!$recipient) {
            Log::warning('AI Blog Automation: no admin email configured, skipping summary mail.');
            $settings->update(['last_summary_sent_date' => $today]);
            return self::SUCCESS;
        }

        try {
            Mail::to($recipient)->send(new AiBlogDraftsReadyMail(
                $completed->pluck('post')->filter()->values(),
                $failed->values(),
                (bool) $settings->auto_publish
            ));
            $this->info("Summary email sent to {$recipient}.");
        } catch (\Throwable $e) {
            Log::error('AI Blog Automation summary mail failed', ['error' => $e->getMessage()]);
        }

        $settings->update(['last_summary_sent_date' => $today]);

        return self::SUCCESS;
    }
}
