<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAiBlogPostJob;
use App\Models\AiBlogSchedule;
use App\Models\AiBlogSetting;
use App\Models\AiBlogTopic;
use App\Services\AiBlog\EvergreenTopicService;
use App\Services\AiBlog\TrendService;
use App\Services\AiBlog\UpcomingEventService;
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

            $dispatched = 0;
            $parts = [];

            foreach ($schedule->countsByType() as $type => $count) {
                if ($count < 1) {
                    continue;
                }

                $made = $this->dispatchType(
                    $type,
                    $count,
                    $trends,
                    $settings,
                    $schedule->trend_country ?: null,
                    $schedule->category_id,
                    $schedule->id
                );

                $dispatched += $made;
                $parts[] = "{$type} {$made}/{$count}";
            }

            $schedule->update([
                'last_run_date' => now()->toDateString(),
                'last_run_summary' => "Dispatched {$dispatched} topic(s) (" . implode(', ', $parts) . ') at ' . now()->toDateTimeString(),
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

    protected function dispatchType(
        string $type,
        int $count,
        TrendService $trends,
        AiBlogSetting $settings,
        ?string $countryOverride,
        ?int $categoryOverride,
        ?int $scheduleId
    ): int {
        return match ($type) {
            'upcoming' => $this->dispatchUpcoming($count, $settings, $categoryOverride, $scheduleId),
            'evergreen' => $this->dispatchEvergreen($count, $settings, $categoryOverride, $scheduleId),
            default => $this->dispatchBatch($trends, $settings, $count, $countryOverride, $categoryOverride, $scheduleId),
        };
    }

    /**
     * Upcoming date posts: nearest events first (2 to 6 weeks ahead). If no event
     * is currently in the window, fall back to seasonal evergreen topics so the slot is not wasted.
     */
    protected function dispatchUpcoming(int $limit, AiBlogSetting $settings, ?int $categoryOverride, ?int $scheduleId): int
    {
        $dispatched = 0;

        foreach (app(UpcomingEventService::class)->upcomingTopics() as $candidate) {
            if ($dispatched >= $limit) {
                break;
            }

            if ($this->createAndDispatch('upcoming', $candidate, 'US', $categoryOverride, $scheduleId)) {
                $dispatched++;
            }
        }

        if ($dispatched < $limit) {
            foreach (app(EvergreenTopicService::class)->pick($settings, $limit - $dispatched, true) as $candidate) {
                if ($this->createAndDispatch('upcoming', $candidate, 'US', $categoryOverride, $scheduleId)) {
                    $dispatched++;
                }
            }
        }

        if ($dispatched < $limit) {
            Log::warning('AI Blog upcoming slot could not fill all posts', ['wanted' => $limit, 'made' => $dispatched]);
        }

        return $dispatched;
    }

    protected function dispatchEvergreen(int $limit, AiBlogSetting $settings, ?int $categoryOverride, ?int $scheduleId): int
    {
        $dispatched = 0;

        foreach (app(EvergreenTopicService::class)->pick($settings, $limit, false) as $candidate) {
            if ($dispatched >= $limit) {
                break;
            }

            if ($this->createAndDispatch('evergreen', $candidate, 'US', $categoryOverride, $scheduleId)) {
                $dispatched++;
            }
        }

        if ($dispatched < $limit) {
            Log::warning('AI Blog evergreen slot could not fill all posts', ['wanted' => $limit, 'made' => $dispatched]);
        }

        return $dispatched;
    }

    protected function createAndDispatch(string $type, array $candidate, ?string $country, ?int $categoryId, ?int $scheduleId): bool
    {
        $hash = AiBlogTopic::hashFor($candidate['topic']);

        if (AiBlogTopic::where('topic_hash', $hash)->exists()) {
            return false;
        }

        $topic = AiBlogTopic::create([
            'topic' => $candidate['topic'],
            'topic_hash' => $hash,
            'type' => $type,
            'source_key' => $candidate['source_key'] ?? null,
            'context' => $candidate['context'] ?? '',
            'country' => $country,
            'category_id' => $categoryId,
            'ai_blog_schedule_id' => $scheduleId,
            'status' => 'pending',
            'fetched_at' => now(),
        ]);

        GenerateAiBlogPostJob::dispatch($topic->id);

        return true;
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

            $country = $candidate['country'] ?? $countryOverride ?? $settings->trend_country;

            if ($this->createAndDispatch('trend', $candidate, $country, $categoryOverride, $scheduleId)) {
                $dispatched++;
            }
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
