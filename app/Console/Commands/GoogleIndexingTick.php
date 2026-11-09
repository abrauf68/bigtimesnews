<?php

namespace App\Console\Commands;

use App\Models\IndexingSite;
use App\Services\GoogleIndexing\BatchService;
use Illuminate\Console\Command;

class GoogleIndexingTick extends Command
{
    protected $signature = 'google-indexing:tick';
    protected $description = 'Runs each site\'s daily inspection batch once its configured batch time has passed.';

    public function handle(BatchService $batches): int
    {
        $today = now()->toDateString();
        $nowTime = now()->format('H:i');

        IndexingSite::active()->get()->each(function (IndexingSite $site) use ($batches, $today, $nowTime) {
            if (!$site->isConnected()) {
                return;
            }
            if ($site->last_batch_date && $site->last_batch_date->toDateString() === $today) {
                return; // already ran today
            }
            if ($nowTime < $site->batchTimeShort()) {
                return;
            }

            $result = $batches->run($site, true);
            $this->info("{$site->name}: {$result['queued']} URL(s) queued.");
        });

        return self::SUCCESS;
    }
}
