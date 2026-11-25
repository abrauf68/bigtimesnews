<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // --- AI Blog Automation -------------------------------------------------
        // On shared hosting there is usually only ONE cron entry allowed/available:
        //   * * * * * cd /path-to-your-app && php artisan schedule:run >> /dev/null 2>&1
        // Everything below runs off that single entry, no daemon/worker process needed.

        // 1) Checks daily_post_limit / run_time and dispatches jobs for new trending topics.
        //    The command itself guards against running more than once per day.
        $schedule->command('ai-blog:run')
            ->everyFiveMinutes()
            ->withoutOverlapping(10);

        // 2) Processes queued jobs (QUEUE_CONNECTION=database). Each invocation grabs
        //    whatever is pending and exits, which fits shared hosting's process-per-cron model.
        $schedule->command('queue:work --queue=default --stop-when-empty --max-time=250 --timeout=600 --tries=2')
            ->everyFiveMinutes()
            ->withoutOverlapping(20); // short lock: if the host kills the worker, the lock must not block the queue for 24h (Laravel's default)

        // 2b) Rescues topics stuck on "Generating" (worker killed by the host mid-run).
        $schedule->command('ai-blog:recover-stuck')
            ->everyTenMinutes()
            ->withoutOverlapping(10);

        // 3) Once the whole batch has finished (success or failure), emails the admin.
        $schedule->command('ai-blog:send-summary')
            ->everyFiveMinutes()
            ->withoutOverlapping(10);

        // --- Google Indexing module -------------------------------------------
        // Runs each site's daily batch once its batch time has passed (the command guards "once per day").
        $schedule->command('google-indexing:tick')
            ->everyFiveMinutes()
            ->withoutOverlapping(10);

        // Discovers new URLs from each site's sitemap.
        $schedule->command('google-indexing:sync-sitemaps')
            ->hourly()
            ->withoutOverlapping(10);

        $schedule->command('google-indexing:prune')->dailyAt('04:30');

        $schedule->command('social:refresh-tokens')
            ->everyTenMinutes()
            ->withoutOverlapping(10);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
