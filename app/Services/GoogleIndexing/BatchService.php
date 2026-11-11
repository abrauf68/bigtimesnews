<?php

namespace App\Services\GoogleIndexing;

use App\Jobs\GoogleIndexing\InspectUrlJob;
use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Models\IndexingUrl;

class BatchService
{
    /**
     * Queue inspections for one site: never-inspected URLs first, then previously
     * not-indexed/errored URLs that are due, then indexed URLs due for a recheck.
     * Respects the site's batch size and today's remaining API quota.
     *
     * @return array{queued:int, remaining_quota:int}
     */
    public function run(IndexingSite $site, bool $scheduled = true): array
    {
        if (!$site->is_active || !$site->isConnected()) {
            return ['queued' => 0, 'remaining_quota' => 0];
        }

        $remaining = max(0, $site->effectiveDailyLimit() - IndexingApiUsage::inspectionsToday($site->id));
        $take = min((int) $site->batch_size, $remaining);
        $ids = [];

        if ($take > 0) {
            $ids = IndexingUrl::where('site_id', $site->id)
                ->where('status', IndexingUrl::STATUS_PENDING)
                ->orderBy('id')->limit($take)->pluck('id')->all();

            // URLs the admin already requested in Search Console are re-checked first, so "Requested" turns to "Indexed" quickly.
            if (count($ids) < $take) {
                $ids = array_merge($ids, IndexingUrl::where('site_id', $site->id)
                    ->whereNotNull('requested_at')
                    ->where('status', '!=', IndexingUrl::STATUS_INDEXED)
                    ->where('status', '!=', IndexingUrl::STATUS_PENDING)
                    ->where(function ($q) {
                        $q->whereNull('next_inspect_at')->orWhere('next_inspect_at', '<=', now());
                    })
                    ->orderBy('next_inspect_at')->limit($take - count($ids))->pluck('id')->all());
            }

            if (count($ids) < $take) {
                $ids = array_merge($ids, $this->due($site, [IndexingUrl::STATUS_NOT_INDEXED, IndexingUrl::STATUS_ERROR], $take - count($ids)));
            }

            if (count($ids) < $take) {
                $ids = array_merge($ids, $this->due($site, [IndexingUrl::STATUS_INDEXED], $take - count($ids)));
            }

            foreach ($ids as $i => $id) {
                // Spread the work out a little so one worker run is not one giant burst.
                InspectUrlJob::dispatch($id)->delay(now()->addSeconds(min($i, 900)));
            }
        }

        $update = ['last_batch_at' => now()];
        if ($scheduled) {
            $update['last_batch_date'] = now()->toDateString();
        }
        $site->update($update);

        IndexingLog::record($site->id, 'batch', 'info',
            sprintf('%s batch: %d URL(s) queued for inspection (%d API calls left today).', $scheduled ? 'Daily' : 'Manual', count($ids), max(0, $remaining - count($ids))));

        return ['queued' => count($ids), 'remaining_quota' => max(0, $remaining - count($ids))];
    }

    /** @return array<int,int> */
    protected function due(IndexingSite $site, array $statuses, int $limit): array
    {
        return IndexingUrl::where('site_id', $site->id)
            ->whereIn('status', $statuses)
            ->where(function ($q) {
                $q->whereNull('next_inspect_at')->orWhere('next_inspect_at', '<=', now());
            })
            ->orderByRaw('next_inspect_at IS NULL DESC')
            ->orderBy('next_inspect_at')
            ->limit($limit)->pluck('id')->all();
    }
}
