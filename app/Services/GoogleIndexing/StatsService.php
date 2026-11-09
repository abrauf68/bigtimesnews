<?php

namespace App\Services\GoogleIndexing;

use App\Models\IndexingApiUsage;
use App\Models\IndexingSite;
use App\Models\IndexingUrl;
use Illuminate\Support\Facades\DB;

class StatsService
{
    /**
     * @param array<int,int>|null $siteIds null = all sites
     * @return array<string,mixed>
     */
    public function build(?array $siteIds = null, int $days = 14): array
    {
        $urls = IndexingUrl::query();
        $usage = IndexingApiUsage::query();
        $sites = IndexingSite::query();
        if ($siteIds !== null) {
            $urls->whereIn('site_id', $siteIds);
            $usage->whereIn('site_id', $siteIds);
            $sites->whereIn('id', $siteIds);
        }

        $counts = (clone $urls)->select('status', DB::raw('COUNT(*) as c'))->groupBy('status')->pluck('c', 'status');
        $total = (int) $counts->sum();
        $indexed = (int) ($counts[IndexingUrl::STATUS_INDEXED] ?? 0);

        $today = now()->toDateString();
        $usedToday = (int) (clone $usage)->whereDate('usage_date', $today)->sum('inspections');
        $limitToday = (int) $sites->get()->sum(fn ($s) => $s->is_active ? $s->effectiveDailyLimit() : 0);

        // Daily series for the charts.
        $labels = [];
        $dates = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $d = now()->subDays($i);
            $dates[] = $d->toDateString();
            $labels[] = $d->format('M j');
        }
        $since = now()->subDays($days - 1)->startOfDay();

        $inspections = (clone $usage)->where('usage_date', '>=', $since->toDateString())
            ->select('usage_date', DB::raw('SUM(inspections) as c'))->groupBy('usage_date')->pluck('c', 'usage_date')
            ->mapWithKeys(fn ($v, $k) => [substr((string) $k, 0, 10) => (int) $v]);

        $newIndexed = (clone $urls)->where('first_indexed_at', '>=', $since)
            ->select(DB::raw('DATE(first_indexed_at) as d'), DB::raw('COUNT(*) as c'))->groupBy('d')->pluck('c', 'd');

        $newUrls = (clone $urls)->where('created_at', '>=', $since)
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as c'))->groupBy('d')->pluck('c', 'd');

        return [
            'total' => $total,
            'indexed' => $indexed,
            'not_indexed' => (int) ($counts[IndexingUrl::STATUS_NOT_INDEXED] ?? 0),
            'pending' => (int) ($counts[IndexingUrl::STATUS_PENDING] ?? 0),
            'error' => (int) ($counts[IndexingUrl::STATUS_ERROR] ?? 0),
            'indexed_pct' => $total > 0 ? round($indexed / $total * 100, 1) : 0,
            'used_today' => $usedToday,
            'limit_today' => $limitToday,
            'labels' => $labels,
            'series_inspections' => array_map(fn ($d) => (int) ($inspections[$d] ?? 0), $dates),
            'series_new_indexed' => array_map(fn ($d) => (int) ($newIndexed[$d] ?? 0), $dates),
            'series_new_urls' => array_map(fn ($d) => (int) ($newUrls[$d] ?? 0), $dates),
        ];
    }

    /** Per-site status counts, keyed by site id. */
    public function perSite(): array
    {
        $rows = IndexingUrl::select('site_id', 'status', DB::raw('COUNT(*) as c'))->groupBy('site_id', 'status')->get();
        $out = [];
        foreach ($rows as $r) {
            $out[$r->site_id][$r->status] = (int) $r->c;
        }

        return $out;
    }
}
