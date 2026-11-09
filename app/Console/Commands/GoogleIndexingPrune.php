<?php

namespace App\Console\Commands;

use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use Illuminate\Console\Command;

class GoogleIndexingPrune extends Command
{
    protected $signature = 'google-indexing:prune';
    protected $description = 'Deletes old activity log and API usage rows.';

    public function handle(): int
    {
        $days = (int) config('google_indexing.log_retention_days', 60);

        $logs = IndexingLog::where('created_at', '<', now()->subDays($days))->delete();
        $usage = IndexingApiUsage::where('usage_date', '<', now()->subDays(max($days, 90)))->delete();

        $this->info("Removed {$logs} log row(s) and {$usage} usage row(s).");

        return self::SUCCESS;
    }
}
