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
            ->withoutOverlapping();

        // 2) Processes queued jobs (QUEUE_CONNECTION=database). Each invocation grabs
        //    whatever is pending and exits, which fits shared hosting's process-per-cron model.
        $schedule->command('queue:work --queue=default --stop-when-empty --max-time=250 --tries=2')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        // 3) Once the whole batch has finished (success or failure), emails the admin.
        $schedule->command('ai-blog:send-summary')
            ->everyFiveMinutes()
            ->withoutOverlapping();
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
