<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnsplashService
{
    public function __construct(protected AiBlogSetting $settings)
    {
    }

    /**
     * Search Unsplash for a photo matching the query, download it into
     * storage/app/public/posts and return the relative path used elsewhere
     * in this app (e.g. "storage/posts/xxx.jpg"), matching PostController's convention.
     *
     * Returns null if no key is configured or nothing suitable was found —
     * callers should fall back gracefully rather than fail the whole post.
     */
    public function fetchImage(string $query, string $slug): ?string
    {
        if (empty($this->settings->unsplash_access_key)) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                    'Authorization' => 'Client-ID ' . $this->settings->unsplash_access_key,
                    'Accept-Version' => 'v1',
                ])
                ->timeout(30)
                ->get('https://api.unsplash.com/search/photos', [
                    'query' => $query,
                    'per_page' => 1,
                    'orientation' => 'landscape',
                    'content_filter' => 'high',
                ]);

            if (!$response->successful()) {
                Log::warning('Unsplash search failed', ['query' => $query, 'status' => $response->status()]);
                return null;
            }

            $results = $response->json('results') ?? [];
            if (empty($results)) {
                return null;
            }

            $photo = $results[0];
            $imageUrl = $photo['urls']['regular'] ?? $photo['urls']['full'] ?? null;
            if (!$imageUrl) {
                return null;
            }

            // Unsplash API guidelines: ping the download endpoint when a photo is actually used.
            if (!empty($photo['links']['download_location'])) {
                try {
                    Http::withHeaders(['Authorization' => 'Client-ID ' . $this->settings->unsplash_access_key])
                        ->timeout(15)
                        ->get($photo['links']['download_location']);
                } catch (\Throwable $e) {
                    // non-fatal, purely an analytics ping
                }
            }

            $imageResponse = Http::timeout(30)->get($imageUrl);
            if (!$imageResponse->successful()) {
                return null;
            }

            $filename = time() . '_' . Str::slug($slug) . '_ai.jpg';
            Storage::put('public/posts/' . $filename, $imageResponse->body());

            return 'storage/posts/' . $filename;
        } catch (\Throwable $e) {
            Log::warning('Unsplash image fetch failed', ['query' => $query, 'error' => $e->getMessage()]);
            return null;
        }
    }

    public function fetchContentImages(array $queries, string $slug): array
    {
        $urls = [];

        foreach (array_values($queries) as $index => $query) {
            $query = trim((string) $query);
            if ($query === '') {
                continue;
            }

            $url = $this->fetchContentImage($query, $slug, $index + 1);
            if ($url) {
                $urls[] = $url;
            }
        }

        return $urls;
    }

    protected function fetchContentImage(string $query, string $slug, int $index): ?string
    {
        if (empty($this->settings->unsplash_access_key)) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                    'Authorization' => 'Client-ID ' . $this->settings->unsplash_access_key,
                    'Accept-Version' => 'v1',
                ])
                ->timeout(30)
                ->get('https://api.unsplash.com/search/photos', [
                    'query' => $query,
                    'per_page' => 1,
                    'orientation' => 'landscape',
                    'content_filter' => 'high',
                ]);

            if (!$response->successful()) {
                Log::warning('Unsplash content image search failed', ['query' => $query, 'status' => $response->status()]);
                return null;
            }

            $results = $response->json('results') ?? [];
            if (empty($results)) {
                return null;
            }

            $photo = $results[0];
            $imageUrl = $photo['urls']['regular'] ?? $photo['urls']['full'] ?? null;
            if (!$imageUrl) {
                return null;
            }

            if (!empty($photo['links']['download_location'])) {
                try {
                    Http::withHeaders(['Authorization' => 'Client-ID ' . $this->settings->unsplash_access_key])
                        ->timeout(15)
                        ->get($photo['links']['download_location']);
                } catch (\Throwable $e) {
                }
            }

            $imageResponse = Http::timeout(30)->get($imageUrl);
            if (!$imageResponse->successful()) {
                return null;
            }

            $filename = time() . '_' . Str::slug($slug) . '_ai_content_' . $index . '.jpg';
            Storage::put('public/posts/content/' . $filename, $imageResponse->body());

            return url('storage/posts/content/' . $filename);
        } catch (\Throwable $e) {
            Log::warning('Unsplash content image fetch failed', ['query' => $query, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
