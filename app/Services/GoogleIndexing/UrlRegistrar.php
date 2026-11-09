<?php

namespace App\Services\GoogleIndexing;

use App\Jobs\GoogleIndexing\InspectUrlJob;
use App\Jobs\GoogleIndexing\SubmitSitemapJob;
use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use App\Models\IndexingUrl;

/**
 * The single entry point for adding URLs. It normalizes, rejects URLs that
 * do not belong to the property, prevents duplicates (unique site_id + url_hash)
 * and dispatches background inspection for newly added URLs.
 */
class UrlRegistrar
{
    public static function normalize(string $url): ?string
    {
        $url = trim($url);
        if ($url === '' || strlen($url) > 2000) {
            return null;
        }

        $parts = parse_url($url);
        if (!$parts || empty($parts['host']) || !in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)) {
            return null;
        }

        $normalized = strtolower($parts['scheme']) . '://' . strtolower($parts['host']);
        if (!empty($parts['port'])) {
            $normalized .= ':' . $parts['port'];
        }
        $normalized .= ($parts['path'] ?? '') !== '' ? $parts['path'] : '/';
        if (isset($parts['query']) && $parts['query'] !== '') {
            $normalized .= '?' . $parts['query'];
        }

        return $normalized; // fragment is dropped on purpose
    }

    /**
     * @param iterable<string> $urls
     * @param array<string,string|null> $lastmods normalized URL => sitemap lastmod
     * @return array{added:int, duplicates:int, rejected:int, queued:int}
     */
    public function add(IndexingSite $site, iterable $urls, string $source = 'manual', ?int $postId = null, bool $dispatch = true, array $lastmods = []): array
    {
        $candidates = [];
        $rejected = 0;
        $seen = 0;

        foreach ($urls as $raw) {
            $seen++;
            $normalized = self::normalize((string) $raw);
            if ($normalized === null || !$site->ownsUrl($normalized)) {
                $rejected++;
                continue;
            }
            $candidates[IndexingUrl::hashUrl($normalized)] = $normalized;
        }

        $duplicatesInInput = $seen - $rejected - count($candidates);
        $newIds = [];
        $duplicates = max(0, $duplicatesInInput);

        foreach (array_chunk($candidates, 500, true) as $chunk) {
            $existing = IndexingUrl::where('site_id', $site->id)->whereIn('url_hash', array_keys($chunk))->pluck('url_hash')->all();
            $existing = array_flip($existing);
            $duplicates += count($existing);

            $now = now();
            $rows = [];
            $dates = app(PostDateResolver::class)->resolve(array_values(array_diff_key($chunk, $existing)));
            foreach ($chunk as $hash => $url) {
                if (isset($existing[$hash])) {
                    continue;
                }
                $lastmod = $lastmods[$url] ?? null;
                $rows[] = [
                    'site_id' => $site->id,
                    'url' => $url,
                    'url_hash' => $hash,
                    'source' => $source,
                    'post_id' => $postId ?? ($dates[$url]['post_id'] ?? null),
                    'published_at' => $dates[$url]['published_at'] ?? null,
                    'status' => IndexingUrl::STATUS_PENDING,
                    'sitemap_lastmod' => $lastmod ? $this->parseDate($lastmod) : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if ($rows) {
                // insertOrIgnore + the unique index also protects against concurrent duplicates.
                IndexingUrl::insertOrIgnore($rows);
                $hashes = array_column($rows, 'url_hash');
                $newIds = array_merge($newIds, IndexingUrl::where('site_id', $site->id)->whereIn('url_hash', $hashes)->pluck('id')->all());
            }
        }

        $added = count($newIds);
        $queued = 0;

        if ($added > 0) {
            IndexingLog::record($site->id, $source === 'sitemap' ? 'sitemap' : 'discover', 'info',
                "{$added} new URL(s) added from {$source}" . ($duplicates ? " ({$duplicates} already known)" : '') . '.');

            if ($dispatch && $site->is_active && $site->isConnected()) {
                $queued = $this->dispatchInspections($site, $newIds);
            }

            // A fresh post/URL: let Google know via the sitemap (debounced, runs once per 10 minutes).
            if ($source === 'auto' && $site->sitemap_url && $site->isConnected()) {
                SubmitSitemapJob::dispatch($site->id)->delay(now()->addMinutes(2));
            }
        }

        return ['added' => $added, 'duplicates' => $duplicates, 'rejected' => $rejected, 'queued' => $queued];
    }

    /** Dispatch inspections for new URLs up to today's remaining quota; the rest wait for the daily batch. */
    protected function dispatchInspections(IndexingSite $site, array $ids): int
    {
        $remaining = max(0, $site->effectiveDailyLimit() - IndexingApiUsage::inspectionsToday($site->id));
        $ids = array_slice($ids, 0, $remaining);

        foreach ($ids as $i => $id) {
            InspectUrlJob::dispatch($id)->delay(now()->addSeconds(min($i, 600)));
        }

        return count($ids);
    }

    protected function parseDate(string $value): ?\Carbon\Carbon
    {
        try {
            return \Carbon\Carbon::parse($value)->setTimezone(config('app.timezone'));
        } catch (\Throwable $e) {
            return null;
        }
    }
}
