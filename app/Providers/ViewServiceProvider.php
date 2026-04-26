<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
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
                return Post::select('id', 'title', 'slug')
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

            $view->with([
                'tickerPosts' => $tickerPosts,
                'navbarCategories' => $navbarCategories,
            ]);
        });


        // Load top posts for home section
        View::composer('frontend.sections.top-posts', function ($view) {
            $topPosts = Cache::remember('top_posts_this_month', 3600, function () {
                return Post::topPostsThisMonth(10)->get();
            });

            $view->with('topPosts', $topPosts);
        });

        // Load featured slider posts (most liked from last 30 days)
        View::composer('frontend.sections.featured-slider', function ($view) {
            $featuredPosts = Cache::remember('featured_slider_posts', 3600, function () {
                return Post::featuredSlider(4)->get();
            });
            
            $view->with('featuredPosts', $featuredPosts);
        });
    }
}
