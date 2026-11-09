<?php

namespace App\Jobs\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleAuthException;
use App\Exceptions\GoogleIndexing\GoogleRateLimitException;
use App\Models\IndexingLog;
use App\Models\IndexingUrl;
use App\Services\GoogleIndexing\InspectionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class InspectUrlJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 8;          // rate-limit releases also count as attempts
    public int $maxExceptions = 3;  // real failures
    public int $timeout = 90;
    public int $uniqueFor = 900;    // the same URL is never queued twice at once

    public function __construct(public int $urlId)
    {
    }

    public function uniqueId(): string
    {
        return (string) $this->urlId;
    }

    public function backoff(): array
    {
        return [60, 300, 900];
    }

    public function handle(InspectionService $service): void
    {
        $url = IndexingUrl::with('site')->find($this->urlId);
        if (!$url) {
            return;
        }

        try {
            $service->inspect($url);
        } catch (GoogleRateLimitException $e) {
            IndexingLog::record($url->site_id, 'inspect', 'warning', 'Google rate limit hit, retrying later.', [], $url->id);
            $this->release(120 * max(1, $this->attempts()));
        } catch (GoogleAuthException $e) {
            // Retrying cannot fix a revoked token or missing permission.
            $this->fail($e);
        }
    }

    public function failed(Throwable $e): void
    {
        $url = IndexingUrl::find($this->urlId);
        if ($url) {
            IndexingLog::record($url->site_id, 'inspect', 'error', 'Inspection failed: ' . $e->getMessage(), ['url' => $url->url], $url->id);
        }
    }
}
