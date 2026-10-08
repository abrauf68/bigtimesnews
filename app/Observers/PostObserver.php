<?php

namespace App\Observers;

use App\Jobs\Social\DispatchSocialPublishingJob;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->clearPostCaches();
        $this->maybeDispatchSocialPublishing($post);
        $this->notifySearchEngines($post);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->clearPostCaches();
        $this->maybeDispatchSocialPublishing($post);
        if ($post->wasChanged(['status', 'slug', 'title', 'content', 'published_at'])) {
            $this->notifySearchEngines($post);
        }
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->clearPostCaches();
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        $this->clearPostCaches();
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        $this->clearPostCaches();
    }

    /**
     * Clear all post-related caches
     */
    private function maybeDispatchSocialPublishing(Post $post): void
    {
        if ($post->needsSocialDispatch()) {
            DispatchSocialPublishingJob::dispatch($post->id);
        }
    }

    private function notifySearchEngines(Post $post): void
    {
        if ($post->status !== 'published') {
            return;
        }
        // Response bhejne ke baad chalta hai, queue worker ki zaroorat nahi
        dispatch(function () use ($post) {
            \App\Services\IndexNowService::submitPost($post->fresh(['category']) ?? $post);
        })->afterResponse();
    }

    private function clearPostCaches(): void
    {
        // Sitemap fresh rakhne ke liye
        Cache::forget('sitemap:main:urls');

        // Clear navbar latest posts
        Cache::forget('navbar_latest_posts');

        // Clear popular posts sidebar
        Cache::forget('popular_posts_sidebar');

        // Clear navbar categories only
        Cache::forget('navbar_categories_only');

        // Clear top posts this month
        Cache::forget('top_posts_this_month');

        // Clear featured slider posts
        Cache::forget('featured_slider_posts');

        // Clear all categories with posts
        Cache::forget('all_categories_with_posts');

        // Clear all category sections (dynamic keys)
        $allCategories = Cache::get('all_categories_list', []);
        foreach ($allCategories as $category) {
            Cache::forget("navbar_category_{$category->slug}_posts");
            Cache::forget("category_section_{$category->slug}");
        }
    }

}
