<?php

namespace App\Services\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleApiException;
use App\Exceptions\GoogleIndexing\GoogleAuthException;
use App\Exceptions\GoogleIndexing\GoogleRateLimitException;
use App\Models\IndexingSite;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Thin wrapper over the Search Console APIs.
 *
 * NOTE: URL Inspection only REPORTS the index status of a URL. It cannot request indexing.
 * The module deliberately does not use the restricted Google Indexing API.
 */
class SearchConsoleClient
{
    protected const SITES = 'https://www.googleapis.com/webmasters/v3/sites';
    protected const INSPECT = 'https://searchconsole.googleapis.com/v1/urlInspection/index:inspect';

    public function __construct(protected GoogleOAuthService $oauth)
    {
    }

    /** @return array<int, array{siteUrl:string, permissionLevel:string}> */
    public function listSites(IndexingSite $site): array
    {
        $response = $this->send($site, fn ($http) => $http->get(self::SITES));

        return $response->json('siteEntry') ?? [];
    }

    public function submitSitemap(IndexingSite $site, string $sitemapUrl): void
    {
        $url = self::SITES . '/' . rawurlencode($site->property_url) . '/sitemaps/' . rawurlencode($sitemapUrl);

        $this->send($site, fn ($http) => $http->withBody('', 'application/json')->put($url));
    }

    /** @return array<string, mixed> */
    public function getSitemap(IndexingSite $site, string $sitemapUrl): array
    {
        $url = self::SITES . '/' . rawurlencode($site->property_url) . '/sitemaps/' . rawurlencode($sitemapUrl);

        return $this->send($site, fn ($http) => $http->get($url))->json() ?? [];
    }

    /** @return array<string, mixed> raw inspectionResult */
    public function inspect(IndexingSite $site, string $pageUrl): array
    {
        $response = $this->send($site, fn ($http) => $http->post(self::INSPECT, [
            'inspectionUrl' => $pageUrl,
            'siteUrl' => $site->property_url,
            'languageCode' => 'en-US',
        ]));

        return $response->json('inspectionResult') ?? [];
    }

    /** Sends a request, refreshing the token once on 401, and maps failures to typed exceptions. */
    protected function send(IndexingSite $site, callable $call): Response
    {
        $response = $call(Http::withToken($this->oauth->validAccessToken($site))->timeout(40)->acceptJson());

        if ($response->status() === 401) {
            $response = $call(Http::withToken($this->oauth->validAccessToken($site, true))->timeout(40)->acceptJson());
        }

        if ($response->successful()) {
            return $response;
        }

        $status = $response->status();
        $message = $response->json('error.message') ?: mb_substr($response->body(), 0, 300);
        $reason = $response->json('error.errors.0.reason') ?? $response->json('error.status');

        if ($status === 429 || in_array($reason, ['rateLimitExceeded', 'quotaExceeded', 'RESOURCE_EXHAUSTED', 'userRateLimitExceeded'], true)) {
            throw new GoogleRateLimitException('Google API rate limit or quota reached: ' . $message, 429);
        }

        if (in_array($status, [401, 403], true)) {
            throw new GoogleAuthException("Google rejected the request (HTTP {$status}): {$message}", $status);
        }

        throw new GoogleApiException("Google API error (HTTP {$status}): {$message}", $status);
    }
}
