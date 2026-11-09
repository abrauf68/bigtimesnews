<?php

namespace App\Console\Commands;

use App\Jobs\GoogleIndexing\SyncSitemapJob;
use App\Models\IndexingSite;
use Illuminate\Console\Command;

class GoogleIndexingSyncSitemaps extends Command
{
    protected $signature = 'google-indexing:sync-sitemaps';
    protected $description = 'Queues a sitemap sync for every active site with automatic discovery enabled.';

    public function handle(): int
    {
        IndexingSite::active()->where('auto_discover', true)->whereNotNull('sitemap_url')->get()->each(function (IndexingSite $site) {
            SyncSitemapJob::dispatch($site->id);
            $this->info("Sitemap sync queued for {$site->name}.");
        });

        return self::SUCCESS;
    }
}
