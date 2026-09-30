<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAiBlogPostJob;
use App\Models\AiBlogSchedule;
use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use App\Services\AiBlog\TrendService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunAiBlogAutomation extends Command
{
    protected $signature = 'ai-blog:run {--force}';

    protected $description = 'Fetch trending topics and dispatch AI blog post generation jobs for today\'s scheduled time slots.';

    public function handle(TrendService $trends): int
    {
        $settings = AiBlogSetting::first();

        if (!$settings || !$settings->is_enabled) {
            $this->info('AI Blog Automation is disabled. Nothing to do.');
            return self::SUCCESS;
        }

        $force = (bool) $this->option('force');
        $schedules = AiBlogSchedule::where('is_enabled', true)->orderBy('run_time')->get();

        if ($schedules->isEmpty()) {
            return $this->runLegacySingleSlot($settings, $trends, $force);
        }

        $totalDispatched = 0;
        $ranAnySlot = false;

        foreach ($schedules as $schedule) {
            if (!$force && !$schedule->isDue()) {
                continue;
            }

            $ranAnySlot = true;

            $dispatched = $this->dispatchBatch(
                $trends,
                $settings,
                max(1, (int) $schedule->post_count),
                $schedule->trend_country ?: null,
                $schedule->category_id,
                $schedule->id
            );

            $schedule->update([
                'last_run_date' => now()->toDateString(),
                'last_run_summary' => "Dispatched {$dispatched} topic(s) at " . now()->toDateTimeString(),
            ]);

            $totalDispatched += $dispatched;
        }

        if ($ranAnySlot) {
            $settings->update([
                'last_run_date' => now()->toDateString(),
                'last_run_summary' => "Dispatched {$totalDispatched} topic(s) across {$schedules->count()} time slot(s) on " . now()->toDateTimeString(),
            ]);
        }

        Log::info('AI Blog Automation run complete (multi-slot)', ['dispatched' => $totalDispatched]);
        $this->info("Dispatched {$totalDispatched} topic(s) across due time slots.");

        return self::SUCCESS;
    }

    protected function runLegacySingleSlot(AiBlogSetting $settings, TrendService $trends, bool $force): int
    {
        $today = now()->toDateString();

        if (!$force) {
            if ($settings->last_run_date && $settings->last_run_date->toDateString() === $today) {
                $this->info('Already ran today.');
                return self::SUCCESS;
            }

            $configuredTime = $settings->run_time ? now()->createFromFormat('H:i:s', $settings->run_time) : null;
            if ($configuredTime && now()->lt($configuredTime)) {
                return self::SUCCESS;
            }
        }

        $limit = max(1, (int) $settings->daily_post_limit);

        $dispatched = $this->dispatchBatch($trends, $settings, $limit, null, null, null);

        $settings->update([
            'last_run_date' => $today,
            'last_run_summary' => "Dispatched {$dispatched} topic(s) for " . now()->toDateTimeString(),
        ]);

        Log::info('AI Blog Automation run complete (legacy single-slot)', ['dispatched' => $dispatched]);
        $this->info("Dispatched {$dispatched} topic(s) for generation.");

        return self::SUCCESS;
    }

    protected function dispatchBatch(
        TrendService $trends,
        AiBlogSetting $settings,
        int $limit,
        ?string $countryOverride,
        ?int $categoryOverride,
        ?int $scheduleId
    ): int {
        $effectiveSettings = $countryOverride ? $this->withCountryOverride($settings, $countryOverride) : $settings;

        $candidates = $trends->getTrendingTopics($effectiveSettings, $limit * 5);

        $dispatched = 0;

        foreach ($candidates as $candidate) {
            if ($dispatched >= $limit) {
                break;
            }

            $hash = AiBlogTopic::hashFor($candidate['topic']);

            if (AiBlogTopic::where('topic_hash', $hash)->exists()) {
                continue;
            }

            $topic = AiBlogTopic::create([
                'topic' => $candidate['topic'],
                'topic_hash' => $hash,
                'context' => $candidate['context'] ?? '',
                'country' => $candidate['country'] ?? $countryOverride ?? $settings->trend_country,
                'category_id' => $categoryOverride,
                'ai_blog_schedule_id' => $scheduleId,
                'status' => 'pending',
                'fetched_at' => now(),
            ]);

            GenerateAiBlogPostJob::dispatch($topic->id);
            $dispatched++;
        }

        return $dispatched;
    }

    protected function withCountryOverride(AiBlogSetting $settings, string $country): AiBlogSetting
    {
        $clone = clone $settings;
        $clone->trend_country = $country;

        return $clone;
    }
}
