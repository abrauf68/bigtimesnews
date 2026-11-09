<?php

namespace App\Jobs\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleAuthException;
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

class SubmitSitemapJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public int $uniqueFor = 600; // many new posts in a short time trigger a single submission

    public function __construct(public int $siteId)
    {
    }

    public function uniqueId(): string
    {
        return (string) $this->siteId;
    }

    public function backoff(): array
    {
        return [120, 600];
    }

    public function handle(SitemapService $service): void
    {
        $site = IndexingSite::find($this->siteId);
        if (!$site || !$site->is_active || !$site->isConnected() || !$site->sitemap_url) {
            return;
        }

        try {
            $service->submit($site);
        } catch (GoogleAuthException $e) {
            $site->update(['health' => 'unhealthy', 'health_message' => mb_substr($e->getMessage(), 0, 500)]);
            $this->fail($e);
        }
    }

    public function failed(Throwable $e): void
    {
        IndexingLog::record($this->siteId, 'sitemap', 'error', 'Sitemap submission failed: ' . $e->getMessage());
    }
}
