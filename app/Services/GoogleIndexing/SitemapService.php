<?php

namespace App\Services\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleApiException;
use App\Models\IndexingApiUsage;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use Illuminate\Support\Facades\Http;

class SitemapService
{
    public function __construct(protected UrlRegistrar $registrar, protected SearchConsoleClient $client)
    {
    }

    /**
     * Fetches the site's sitemap (following sitemap indexes), imports unknown URLs.
     *
     * @return array{found:int, added:int, duplicates:int, rejected:int, queued:int, files:int}
     */
    public function sync(IndexingSite $site): array
    {
        if (!$site->sitemap_url) {
            throw new GoogleApiException('No sitemap URL is set for this site.');
        }

        $maxDepth = (int) config('google_indexing.sitemap_max_depth', 3);
        $maxFiles = (int) config('google_indexing.sitemap_max_files', 30);
        $maxUrls = (int) config('google_indexing.sitemap_max_urls', 50000);

        $queue = [[$site->sitemap_url, 0]];
        $visited = [];
        $found = [];
        $files = 0;

        while ($queue && $files < $maxFiles && count($found) < $maxUrls) {
            [$sitemapUrl, $depth] = array_shift($queue);
            if (isset($visited[$sitemapUrl])) {
                continue;
            }
            $visited[$sitemapUrl] = true;

            try {
                $xml = $this->fetch($sitemapUrl);
            } catch (\Throwable $e) {
                IndexingLog::record($site->id, 'sitemap', 'error', "Could not fetch {$sitemapUrl}: " . $e->getMessage());
                if ($files === 0) {
                    throw new GoogleApiException('Could not fetch the sitemap: ' . $e->getMessage());
                }
                continue;
            }

            $files++;
            $parsed = SitemapParser::parse($xml);

            if ($parsed['type'] === 'invalid') {
                IndexingLog::record($site->id, 'sitemap', 'warning', "{$sitemapUrl} is not a valid sitemap XML file.");
                continue;
            }

            if ($parsed['type'] === 'index') {
                if ($depth < $maxDepth) {
                    foreach ($parsed['sitemaps'] as $child) {
                        $queue[] = [$child, $depth + 1];
                    }
                }
                continue;
            }

            foreach ($parsed['urls'] as $row) {
                $normalized = UrlRegistrar::normalize($row['loc']);
                if ($normalized !== null && !isset($found[$normalized])) {
                    $found[$normalized] = $row['lastmod'];
                }
            }
        }

        $result = $this->registrar->add($site, array_keys($found), 'sitemap', null, true, $found);

        $site->update(['last_sitemap_sync_at' => now(), 'sitemap_urls_found' => count($found)]);

        IndexingLog::record($site->id, 'sitemap', 'info',
            sprintf('Sitemap synced: %d URL(s) found in %d file(s), %d new.', count($found), $files, $result['added']));

        return ['found' => count($found), 'files' => $files] + $result;
    }

    /** Submits the sitemap to Search Console (this is the real "please crawl these" signal). */
    public function submit(IndexingSite $site): void
    {
        if (!$site->sitemap_url) {
            throw new GoogleApiException('No sitemap URL is set for this site.');
        }

        $this->client->submitSitemap($site, $site->sitemap_url);
        IndexingApiUsage::bump($site->id, 'sitemap_calls');
        $site->update(['last_sitemap_submit_at' => now()]);

        IndexingLog::record($site->id, 'sitemap', 'info', 'Sitemap submitted to Google Search Console.', ['sitemap' => $site->sitemap_url]);
    }

    protected function fetch(string $url): string
    {
        $response = Http::withHeaders(['User-Agent' => config('google_indexing.user_agent'), 'Accept' => 'application/xml,text/xml,*/*'])
            ->timeout(40)->get($url);

        if (!$response->successful()) {
            throw new GoogleApiException("HTTP {$response->status()}");
        }

        $body = $response->body();

        // Handle .xml.gz sitemaps.
        if (str_starts_with($body, "\x1f\x8b")) {
            $body = (string) @gzdecode($body);
        }

        return $body;
    }
}
