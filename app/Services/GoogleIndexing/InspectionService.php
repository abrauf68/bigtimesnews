<?php

namespace App\Services\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleApiException;
use App\Exceptions\GoogleIndexing\GoogleAuthException;
use App\Exceptions\GoogleIndexing\GoogleRateLimitException;
use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use App\Models\IndexingUrl;

class InspectionService
{
    public const DONE = 'inspected';
    public const QUOTA = 'quota';
    public const SKIPPED = 'skipped';

    public function __construct(protected SearchConsoleClient $client)
    {
    }

    /**
     * Inspects one URL with the URL Inspection API (read-only status check) and stores the result.
     * Throws GoogleRateLimitException / GoogleAuthException / GoogleApiException for the job to handle.
     */
    public function inspect(IndexingUrl $url): string
    {
        $site = $url->site;

        if (!$site || !$site->is_active || !$site->isConnected()) {
            return self::SKIPPED;
        }

        $used = IndexingApiUsage::inspectionsToday($site->id);
        if ($used >= $site->effectiveDailyLimit()) {
            // Try again after the daily quota resets; keep the URL in its current state.
            $url->update(['next_inspect_at' => now()->addDay()->startOfDay()->addMinutes(10)]);

            return self::QUOTA;
        }

        try {
            $result = $this->client->inspect($site, $url->url);
        } catch (GoogleRateLimitException $e) {
            throw $e; // a rate-limited request did not consume quota
        } catch (GoogleAuthException $e) {
            $site->update(['health' => 'unhealthy', 'health_message' => mb_substr($e->getMessage(), 0, 500)]);
            IndexingLog::record($site->id, 'inspect', 'error', 'Authorization problem: ' . $e->getMessage(), [], $url->id);
            throw $e;
        } catch (GoogleApiException $e) {
            IndexingApiUsage::bump($site->id, 'inspections');
            IndexingApiUsage::bump($site->id, 'errors');
            $url->update([
                'status' => IndexingUrl::STATUS_ERROR,
                'last_error' => mb_substr($e->getMessage(), 0, 1000),
                'next_inspect_at' => now()->addDay(),
            ]);
            throw $e;
        }

        IndexingApiUsage::bump($site->id, 'inspections');

        $mapped = InspectionResultMapper::map($result);
        $previous = $url->status;
        $status = $mapped['status'];

        $update = $mapped + [
            'inspect_count' => $url->inspect_count + 1,
            'inspected_at' => now(),
        ];

        if ($status === IndexingUrl::STATUS_INDEXED) {
            $update['next_inspect_at'] = now()->addDays(max(1, (int) $site->recheck_indexed_days));
            $update['first_indexed_at'] = $url->first_indexed_at ?? now();
        } elseif ($status === IndexingUrl::STATUS_NOT_INDEXED) {
            $update['next_inspect_at'] = now()->addDays(max(1, (int) $site->reinspect_days));
        } else {
            $update['next_inspect_at'] = now()->addDay();
        }

        $url->update($update);

        // The healthy flag is restored by any successful call.
        if (!$site->isHealthy()) {
            $site->update(['health' => 'healthy', 'health_message' => null]);
        }

        // Only log meaningful changes so the activity log stays readable.
        if ($previous !== $status) {
            IndexingLog::record($site->id, 'inspect', 'info',
                ($previous === IndexingUrl::STATUS_PENDING ? 'First inspection' : "Status changed {$previous} → {$status}")
                . ': ' . ($mapped['coverage_state'] ?? $status), ['url' => $url->url], $url->id);
        }

        return self::DONE;
    }
}
