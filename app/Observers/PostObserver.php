<?php

namespace App\Observers;

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
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->clearPostCaches();
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
    private function clearPostCaches(): void
    {
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
