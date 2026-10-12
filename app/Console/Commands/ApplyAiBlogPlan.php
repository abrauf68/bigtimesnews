<?php

namespace App\Console\Commands;

use App\Models\AiBlogSchedule;
use Illuminate\Console\Command;

class ApplyAiBlogPlan extends Command
{
    protected $signature = 'ai-blog:apply-plan';

    protected $description = 'Set the 4 daily time slots to the agreed plan: 3 trend, 2 upcoming date and 3 evergreen posts (8 per day).';

    /** run_time (server time) => [trend, upcoming, evergreen] */
    protected const PLAN = [
        '00:00:00' => [1, 0, 1],
        '04:00:00' => [0, 1, 1],
        '16:00:00' => [1, 1, 0],
        '20:00:00' => [1, 0, 1],
    ];

    public function handle(): int
    {
        foreach (self::PLAN as $time => [$trend, $upcoming, $evergreen]) {
            $slot = AiBlogSchedule::firstOrNew(['run_time' => $time]);
            $slot->fill([
                'trend_count' => $trend,
                'upcoming_count' => $upcoming,
                'evergreen_count' => $evergreen,
                'post_count' => $trend + $upcoming + $evergreen,
                'is_enabled' => true,
            ])->save();

            $this->line(sprintf('%s  trend %d, upcoming %d, evergreen %d', substr($time, 0, 5), $trend, $upcoming, $evergreen));
        }

        $others = AiBlogSchedule::whereNotIn('run_time', array_keys(self::PLAN))->where('is_enabled', true)->count();
        if ($others > 0) {
            $this->warn("{$others} other enabled slot(s) exist and were left unchanged. Disable them in the dashboard if they are not wanted.");
        }

        $this->info('Plan applied: 3 trend + 2 upcoming + 3 evergreen = 8 posts per day.');

        return self::SUCCESS;
    }
}
