<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAiBlogPostJob;
use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use App\Services\AiBlog\TrendService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunAiBlogAutomation extends Command
{
    /**
     * --force skips the "has today's run already happened / is it the configured run_time yet" gate.
     * Used by the admin panel's "Run Now" button.
     */
    protected $signature = 'ai-blog:run {--force}';

    protected $description = 'Fetch trending topics and dispatch AI blog post generation jobs for today\'s batch.';

    public function handle(TrendService $trends): int
    {
        $settings = AiBlogSetting::first();

        if (!$settings || !$settings->is_enabled) {
            $this->info('AI Blog Automation is disabled. Nothing to do.');
            return self::SUCCESS;
        }

        $today = now()->toDateString();
        $force = (bool) $this->option('force');

        if (!$force) {
            if ($settings->last_run_date && $settings->last_run_date->toDateString() === $today) {
                $this->info('Already ran today.');
                return self::SUCCESS;
            }

            $configuredTime = $settings->run_time ? now()->createFromFormat('H:i:s', $settings->run_time) : null;
            if ($configuredTime && now()->lt($configuredTime)) {
                // Not time yet today; the scheduler will call this again shortly.
                return self::SUCCESS;
            }
        }

        $limit = max(1, (int) $settings->daily_post_limit);

        // Fetch more than we need so we still have options after removing already-used topics.
        $candidates = $trends->getTrendingTopics($settings, $limit * 5);

        $dispatched = 0;
        foreach ($candidates as $candidate) {
            if ($dispatched >= $limit) {
                break;
            }

            $hash = AiBlogTopic::hashFor($candidate['topic']);

            if (AiBlogTopic::where('topic_hash', $hash)->exists()) {
                continue; // already written about this trend before
            }

            $topic = AiBlogTopic::create([
                'topic' => $candidate['topic'],
                'topic_hash' => $hash,
                'context' => $candidate['context'] ?? '',
                'country' => $candidate['country'] ?? $settings->trend_country,
                'status' => 'pending',
                'fetched_at' => now(),
            ]);

            GenerateAiBlogPostJob::dispatch($topic->id);
            $dispatched++;
        }

        $settings->update([
            'last_run_date' => $today,
            'last_run_summary' => "Dispatched {$dispatched} topic(s) for " . now()->toDateTimeString(),
        ]);

        Log::info('AI Blog Automation run complete', ['dispatched' => $dispatched]);
        $this->info("Dispatched {$dispatched} topic(s) for generation.");

        return self::SUCCESS;
    }
}
