<?php

namespace App\Services\GoogleIndexing;

use App\Models\IndexingUrl;
use Carbon\Carbon;

/** Pure mapping from a URL Inspection API "inspectionResult" to our columns. */
class InspectionResultMapper
{
    /**
     * @param array<string, mixed> $result
     * @return array<string, mixed>
     */
    public static function map(array $result): array
    {
        $index = $result['indexStatusResult'] ?? null;

        if (!is_array($index)) {
            return ['status' => IndexingUrl::STATUS_ERROR, 'last_error' => 'Google returned no index status for this URL.'];
        }

        $verdict = (string) ($index['verdict'] ?? 'VERDICT_UNSPECIFIED');
        $coverage = (string) ($index['coverageState'] ?? '');

        $indexed = $verdict === 'PASS'
            || (bool) preg_match('/^(submitted and )?indexed\b/i', $coverage) && !preg_match('/not indexed/i', $coverage);

        $lastCrawl = null;
        if (!empty($index['lastCrawlTime'])) {
            try {
                $lastCrawl = Carbon::parse($index['lastCrawlTime'])->setTimezone(config('app.timezone'));
            } catch (\Throwable $e) {
            }
        }

        return [
            'status' => $indexed ? IndexingUrl::STATUS_INDEXED : IndexingUrl::STATUS_NOT_INDEXED,
            'verdict' => $verdict,
            'coverage_state' => $coverage !== '' ? mb_substr($coverage, 0, 255) : null,
            'indexing_state' => $index['indexingState'] ?? null,
            'robots_state' => $index['robotsTxtState'] ?? null,
            'page_fetch_state' => $index['pageFetchState'] ?? null,
            'google_canonical' => $index['googleCanonical'] ?? null,
            'last_crawl_at' => $lastCrawl,
            'last_error' => null,
        ];
    }
}
