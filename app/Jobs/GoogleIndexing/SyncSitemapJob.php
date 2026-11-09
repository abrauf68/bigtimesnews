<?php

namespace App\Jobs\GoogleIndexing;

use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Services\GoogleIndexing\SitemapService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncSitemapJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 180;
    public int $uniqueFor = 300;

    public function __construct(public int $siteId)
    {
    }

    public function uniqueId(): string
    {
        return (string) $this->siteId;
    }

    public function backoff(): array
    {
        return [120];
    }

    public function handle(SitemapService $service): void
    {
        $site = IndexingSite::find($this->siteId);
        if (!$site || !$site->is_active || !$site->sitemap_url) {
            return;
        }

        $service->sync($site);
    }

    public function failed(Throwable $e): void
    {
        IndexingLog::record($this->siteId, 'sitemap', 'error', 'Sitemap sync failed: ' . $e->getMessage());
    }
}
