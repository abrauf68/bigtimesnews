<?php

namespace App\Services\GoogleIndexing;

use App\Models\IndexingUrl;
use App\Models\Post;

/** Matches an indexing URL to its blog post (by the last path segment = post slug) to get the publish date. */
class PostDateResolver
{
    public static function slugFromUrl(string $url): ?string
    {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        if ($path === '') {
            return null;
        }
        $parts = explode('/', $path);
        $slug = mb_strtolower(trim(urldecode((string) end($parts))));

        return $slug !== '' ? $slug : null;
    }

    /**
     * @param array<int,string> $urls
     * @return array<string, array{post_id:int, published_at:?\Carbon\Carbon}> keyed by URL
     */
    public function resolve(array $urls): array
    {
        $slugByUrl = [];
        foreach ($urls as $url) {
            if ($slug = self::slugFromUrl($url)) {
                $slugByUrl[$url] = $slug;
            }
        }
        if (!$slugByUrl) {
            return [];
        }

        $posts = Post::whereIn('slug', array_unique(array_values($slugByUrl)))
            ->get(['id', 'slug', 'published_at', 'created_at'])
            ->keyBy(fn ($p) => mb_strtolower($p->slug));

        $out = [];
        foreach ($slugByUrl as $url => $slug) {
            if ($post = $posts->get($slug)) {
                $out[$url] = ['post_id' => $post->id, 'published_at' => $post->published_at ?? $post->created_at];
            }
        }

        return $out;
    }

    /**
     * Fill post_id / published_at on rows that have no date yet.
     * Falls back to the sitemap <lastmod>, then first-seen time, so the column is never empty.
     *
     * @return array{matched:int, fallback:int, unmatched:array<int,string>}
     */
    public function backfill(): array
    {
        $stats = ['matched' => 0, 'fallback' => 0, 'unmatched' => []];

        $ids = IndexingUrl::whereNull('published_at')->pluck('id');

        foreach ($ids->chunk(300) as $chunk) {
            $rows = IndexingUrl::whereIn('id', $chunk)->get();
            $map = $this->resolve($rows->pluck('url')->all());

            foreach ($rows as $row) {
                if (isset($map[$row->url])) {
                    $row->forceFill([
                        'post_id' => $row->post_id ?? $map[$row->url]['post_id'],
                        'published_at' => $map[$row->url]['published_at'],
                    ])->save();
                    $stats['matched']++;
                    continue;
                }

                $fallback = $row->sitemap_lastmod ?? $row->created_at;
                if ($fallback) {
                    $row->forceFill(['published_at' => $fallback])->save();
                    $stats['fallback']++;
                }
                if (count($stats['unmatched']) < 10) {
                    $stats['unmatched'][] = $row->url;
                }
            }
        }

        return $stats;
    }
}
