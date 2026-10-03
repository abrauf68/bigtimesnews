<?php

namespace App\Services\AiBlog;

use App\Models\AiBlogSetting;
use App\Models\AiBlogUsedImage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UnsplashService
{
    // How many of the most-recently-used photos to avoid repeating.
    // A photo can only be reused again once it has aged out of this window
    // (i.e. at least this many other photo uses have happened since).
    protected const REUSE_COOLDOWN = 200;

    public function __construct(protected AiBlogSetting $settings)
    {
    }

    public function fetchImage(string $query, string $slug): ?string
    {
        if (empty($this->settings->unsplash_access_key)) {
            return null;
        }

        $photo = $this->searchUnusedPhoto($query);
        if (!$photo) {
            return null;
        }

        $imageUrl = $photo['urls']['regular'] ?? $photo['urls']['full'] ?? null;
        if (!$imageUrl) {
            return null;
        }

        $this->pingDownload($photo);

        try {
            $imageResponse = Http::timeout(30)->get($imageUrl);
            if (!$imageResponse->successful()) {
                return null;
            }

            $filename = time() . '_' . Str::slug($slug) . '_ai.jpg';
            Storage::put('public/posts/' . $filename, $imageResponse->body());

            $this->markPhotoUsed($photo['id']);

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

        $photo = $this->searchUnusedPhoto($query);
        if (!$photo) {
            return null;
        }

        $imageUrl = $photo['urls']['regular'] ?? $photo['urls']['full'] ?? null;
        if (!$imageUrl) {
            return null;
        }

        $this->pingDownload($photo);

        try {
            $imageResponse = Http::timeout(30)->get($imageUrl);
            if (!$imageResponse->successful()) {
                return null;
            }

            $filename = time() . '_' . Str::slug($slug) . '_ai_content_' . $index . '.jpg';
            Storage::put('public/posts/content/' . $filename, $imageResponse->body());

            $this->markPhotoUsed($photo['id']);

            return url('storage/posts/content/' . $filename);
        } catch (\Throwable $e) {
            Log::warning('Unsplash content image fetch failed', ['query' => $query, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Search Unsplash for up to 30 candidates matching the query, then pick
     * the first one that hasn't been used in the last REUSE_COOLDOWN uploads
     * across the whole site (featured + inline images share one pool, since
     * they're all images readers see). Falls back to the single best match
     * if every candidate happens to be in the cooldown window (rare, only
     * when a query is extremely narrow).
     */
    protected function searchUnusedPhoto(string $query): ?array
    {
        try {
            $response = Http::withHeaders([
                    'Authorization' => 'Client-ID ' . $this->settings->unsplash_access_key,
                    'Accept-Version' => 'v1',
                ])
                ->timeout(30)
                ->get('https://api.unsplash.com/search/photos', [
                    'query' => $query,
                    'per_page' => 30, // max allowed by Unsplash's API
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

            $recentlyUsed = $this->recentlyUsedPhotoIds();

            foreach ($results as $candidate) {
                if (!in_array($candidate['id'], $recentlyUsed, true)) {
                    return $candidate;
                }
            }

            // Every candidate for this query has been used recently -- rather
            // than fail the post, fall back to the top match and log it so
            // it's visible how often this query is too narrow.
            Log::info('Unsplash: all candidates in reuse cooldown, falling back to top match', [
                'query' => $query,
            ]);

            return $results[0];
        } catch (\Throwable $e) {
            Log::warning('Unsplash search exception', ['query' => $query, 'error' => $e->getMessage()]);
            return null;
        }
    }

    protected function recentlyUsedPhotoIds(): array
    {
        return AiBlogUsedImage::orderByDesc('used_at')
            ->take(self::REUSE_COOLDOWN)
            ->pluck('photo_id')
            ->all();
    }

    protected function markPhotoUsed(string $photoId): void
    {
        AiBlogUsedImage::create([
            'photo_id' => $photoId,
            'used_at' => now(),
        ]);
    }

    protected function pingDownload(array $photo): void
    {
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
    }
}
