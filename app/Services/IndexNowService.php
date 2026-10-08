<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Publish/update hote hi URL search engines ko batata hai (IndexNow protocol:
 * Bing, Yandex, Seznam, Naver...). Google IndexNow support nahi karta —
 * Google ke liye sitemap + internal links + Search Console use hote hain.
 */
class IndexNowService
{
    public static function key(): ?string
    {
        return config('site.indexnow_key') ?: null;
    }

    public static function submitPost(Post $post): void
    {
        $key = self::key();
        if (!$key || $post->status !== 'published' || !$post->category) {
            return;
        }

        $urls = [
            route('frontend.news.show', [$post->category->slug, $post->slug]),
            route('frontend.archive'),
            url('/sitemap.xml'),
        ];

        try {
            $response = Http::timeout(8)->post('https://api.indexnow.org/indexnow', [
                'host' => parse_url(url('/'), PHP_URL_HOST),
                'key' => $key,
                'keyLocation' => url('/' . $key . '.txt'),
                'urlList' => $urls,
            ]);
            Log::info('IndexNow submitted', ['status' => $response->status(), 'urls' => $urls]);
        } catch (\Throwable $e) {
            Log::warning('IndexNow failed: ' . $e->getMessage());
        }
    }
}
