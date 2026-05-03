<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.header', function ($view) {

            $tickerPosts = cache()->remember('ticker_posts', 60, function () {
                return Post::with('category:id,name,slug')->select('id', 'title', 'slug', 'category_id')
                    ->where('status', 'published')
                    ->latest()
                    ->take(10)
                    ->get();
            });

            $navbarCategories = Cache::remember('navbar_categories_only', 86400, function () {
                return Category::where('is_active', 'active')
                    ->select('id', 'name', 'slug')
                    ->orderBy('name')
                    ->limit(8)
                    ->get();
            });

            Log::info($tickerPosts);

            $view->with([
                'tickerPosts' => $tickerPosts,
                'navbarCategories' => $navbarCategories,
            ]);
        });


        // Load top posts for home section
        View::composer('frontend.sections.top-posts', function ($view) {
            $topPosts = Cache::remember('top_posts_this_month', 3600, function () {
                return Post::with('category:id,name,slug')->topPostsThisMonth(10)->get();
            });

            $view->with('topPosts', $topPosts);
        });

        // Load featured slider posts (most liked from last 30 days)
        View::composer('frontend.sections.featured-slider', function ($view) {
            $featuredPosts = Cache::remember('featured_slider_posts', 3600, function () {
                return Post::with('category:id,name,slug')->featuredSlider(4)->get();
            });

            $view->with('featuredPosts', $featuredPosts);
        });


        // Load all categories sections for home page
        View::composer('frontend.components.category-sections', function ($view) {
            $categories = Cache::remember('all_categories_with_posts', 1800, function () {
                return Category::where('is_active', 'active')
                    ->with(['posts' => function($query) {
                        $query->published()
                            ->withCount('comments')
                            ->latest('published_at')
                            ->take(6);
                    }])
                    ->has('posts')
                    ->take(6)
                    ->get();
            });

            $view->with('categories', $categories);
        });
    }
}
