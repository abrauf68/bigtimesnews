<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FeedController extends Controller
{
    /**
     * RSS 2.0 feed of the latest published articles (summary only, links back to the site).
     * Used by Feedly, Flipboard, news apps and other aggregators. Cached for 5 minutes.
     */
    public function index(): Response
    {
        $xml = Cache::remember('feed:main:xml', now()->addMinutes(5), function () {
            $posts = Post::with('category:id,name,slug')
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->whereHas('category')
                ->latest('published_at')
                ->limit(40)
                ->get(['id', 'title', 'slug', 'category_id', 'meta_description', 'content', 'main_image', 'published_at', 'updated_at']);

            return view('frontend.feed', [
                'posts' => $posts,
                'siteName' => Helper::getCompanyName(),
            ])->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    /** Short plain text summary for a feed item. */
    public static function summary($post): string
    {
        $text = trim((string) $post->meta_description);

        if ($text === '') {
            $text = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post->content))), 280, '...');
        }

        return $text;
    }
}
