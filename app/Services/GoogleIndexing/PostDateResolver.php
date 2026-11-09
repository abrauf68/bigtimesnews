<?php

namespace App\Services\GoogleIndexing;

use App\Models\IndexingUrl;
use App\Models\Post;

/** Matches an indexing URL (/news/{category}/{slug}) to its blog post to get the post's publish date. */
class PostDateResolver
{
    public static function slugFromUrl(string $url): ?string
    {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
        if ($path === '') {
            return null;
        }
        $parts = explode('/', $path);

        return count($parts) >= 3 && $parts[0] === 'news' ? end($parts) : null;
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

        $posts = Post::whereIn('slug', array_unique(array_values($slugByUrl)))->get(['id', 'slug', 'published_at', 'created_at'])->keyBy('slug');

        $out = [];
        foreach ($slugByUrl as $url => $slug) {
            if ($post = $posts->get($slug)) {
                $out[$url] = ['post_id' => $post->id, 'published_at' => $post->published_at ?? $post->created_at];
            }
        }

        return $out;
    }

    /** Fill post_id / published_at on existing rows. Returns the number of rows updated. */
    public function backfill(): int
    {
        $updated = 0;

        IndexingUrl::whereNull('published_at')->chunkById(300, function ($rows) use (&$updated) {
            $map = $this->resolve($rows->pluck('url')->all());
            foreach ($rows as $row) {
                if (isset($map[$row->url])) {
                    $row->update(['post_id' => $row->post_id ?? $map[$row->url]['post_id'], 'published_at' => $map[$row->url]['published_at']]);
                    $updated++;
                }
            }
        });

        return $updated;
    }
}
