<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Main sitemap.xml — static pages, all categories, all published posts.
     * Cached for an hour so search-engine crawl traffic doesn't hammer the DB.
     */
    public function index(): Response
    {
        $urls = Cache::remember('sitemap:main:urls', now()->addHour(), function () {
            $urls = [];

            $urls[] = [
                'loc' => url('/'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'hourly',
                'priority' => '1.0',
            ];

            $urls[] = [
                'loc' => route('frontend.news.index'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'hourly',
                'priority' => '0.9',
            ];

            Category::where('is_active', 'active')->get(['slug', 'updated_at'])->each(function ($category) use (&$urls) {
                $urls[] = [
                    'loc' => route('frontend.news.category', $category->slug),
                    'lastmod' => optional($category->updated_at)->toAtomString() ?? now()->toAtomString(),
                    'changefreq' => 'daily',
                    'priority' => '0.7',
                ];
            });

            Post::where('status', 'published')
                ->with('category:id,slug')
                ->orderByDesc('published_at')
                ->chunk(500, function ($posts) use (&$urls) {
                    foreach ($posts as $post) {
                        if (!$post->category) {
                            continue;
                        }
                        $urls[] = [
                            'loc' => route('frontend.news.show', [$post->category->slug, $post->slug]),
                            'lastmod' => optional($post->updated_at)->toAtomString() ?? now()->toAtomString(),
                            'changefreq' => 'weekly',
                            'priority' => '0.6',
                        ];
                    }
                });

            return $urls;
        });

        return response()
            ->view('frontend.sitemap.index', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Google News sitemap — per Google's spec this must only contain
     * articles published in the last 2 days. Not cached (needs to stay fresh).
     */
    public function news(): Response
    {
        $posts = Post::where('status', 'published')
            ->where('published_at', '>=', now()->subHours(48))
            ->with('category:id,slug')
            ->orderByDesc('published_at')
            ->limit(1000)
            ->get();

        return response()
            ->view('frontend.sitemap.news', [
                'posts' => $posts,
                'publicationName' => Helper::getCompanyName(),
            ])
            ->header('Content-Type', 'application/xml');
    }
}
