<?php

namespace App\Services\GoogleIndexing;

use App\Models\IndexingSite;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Throwable;

/** Automatic discovery: registers a newly published blog post with every matching site. */
class PostDiscovery
{
    public static function postPublished(Post $post): void
    {
        try {
            $post->loadMissing('category');
            if ($post->status !== 'published' || !$post->category) {
                return;
            }

            $url = route('frontend.news.show', [$post->category->slug, $post->slug]);
            $registrar = app(UrlRegistrar::class);

            IndexingSite::active()->where('auto_discover', true)->get()->each(function (IndexingSite $site) use ($registrar, $url, $post) {
                if ($site->ownsUrl($url)) {
                    $registrar->add($site, [$url], 'auto', $post->id);
                }
            });
        } catch (Throwable $e) {
            // Never let indexing bookkeeping break publishing a post.
            Log::warning('Google indexing discovery failed: ' . $e->getMessage());
        }
    }
}
