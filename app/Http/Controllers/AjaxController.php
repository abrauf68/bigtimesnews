<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{
    // For Latest Tab (with sidebar)
    public function getLatestPosts()
    {
        $html = Cache::remember('navbar_latest_posts', 3600, function () {
            $posts = Post::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->withCount('comments')
                ->latest('published_at')
                ->limit(24)
                ->get();

            $categories = Category::where('is_active', 'active')
                ->with(['posts' => function($q) {
                    $q->where('status', 'published')
                      ->whereNotNull('published_at')
                      ->limit(8);
                }])
                ->select('id', 'name', 'slug')
                ->orderBy('name')
                ->get();

            return view('frontend.components.posts-grid', [
                'posts' => $posts,
                'categories' => $categories
            ])->render();
        });

        return response()->json(['html' => $html]);
    }

    // For Category Dropdowns (simple grid, no sidebar)
    public function getCategoryPosts($slug)
    {
        $cacheKey = "navbar_category_{$slug}_posts";

        $html = Cache::remember($cacheKey, 3600, function () use ($slug) {
            $category = Category::where('slug', $slug)
                ->where('is_active', 'active')
                ->firstOrFail();

            $posts = $category->posts()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->withCount('comments')
                ->latest('published_at')
                ->limit(12)
                ->get();

            return view('frontend.components.category-dropdown', [
                'posts' => $posts,
                'category' => $category
            ])->render();
        });

        return response()->json(['html' => $html]);
    }

    // For category switcher inside Latest tab (AJAX call)
    public function getCategorySwitcherPosts($slug)
    {
        if ($slug === 'all') {
            $posts = Post::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->withCount('comments')
                ->latest('published_at')
                ->limit(8)
                ->get();
        } else {
            $category = Category::where('slug', $slug)
                ->where('is_active', 'active')
                ->first();

            if (!$category) {
                return response()->json(['html' => '<div class="text-center py-5">Category not found</div>']);
            }

            $posts = $category->posts()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->withCount('comments')
                ->latest('published_at')
                ->limit(8)
                ->get();
        }

        // Debug: Check if posts exist
        Log::info("Category: {$slug}, Posts count: " . $posts->count());

        $html = view('frontend.components.posts-grid-only', [
            'posts' => $posts
        ])->render();

        return response()->json(['html' => $html]);
    }

    
    /**
     * Get hot now posts for AJAX loading
     */
    public function getHotNowPosts()
    {
        $posts = Post::hotNow(10)->get();
        
        // Return only the slides, not the entire wrapper
        $html = view('frontend.components.hot-now-posts', [
            'posts' => $posts
        ])->render();
        
        return response()->json(['html' => $html]);
    }

    // Get all categories with their posts
    public function getAllCategorySections()
    {
        $html = Cache::remember('all_category_sections', 1800, function () {
            // Get top 5 categories with posts
            $categories = Category::where('is_active', 'active')
                ->with(['posts' => function($query) {
                    $query->published()
                        ->withCount('comments')
                        ->latest('published_at');
                }])
                ->has('posts') // Only categories with posts
                ->take(5)
                ->get();
            
            return view('frontend.components.all-categories-sections', [
                'categories' => $categories
            ])->render();
        });
        
        return response()->json(['html' => $html]);
    }
    
    // Get single category section (for individual loading)
    public function getCategorySection($slug)
    {
        $cacheKey = "category_section_{$slug}";
        
        $html = Cache::remember($cacheKey, 1800, function () use ($slug) {
            $category = Category::where('slug', $slug)
                ->where('is_active', 'active')
                ->firstOrFail();
            
            $posts = $category->posts()
                ->published()
                ->withCount('comments')
                ->latest('published_at')
                ->take(4)
                ->get();
            
            return view('frontend.components.category-section', [
                'category' => $category,
                'posts' => $posts
            ])->render();
        });
        
        return response()->json(['html' => $html]);
    }

    /**
     * Get latest posts with pagination for infinite scroll
     */
    public function getLatestPostsPaginated(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 6; // Load 6 posts per request
        
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->withCount('comments')
            ->with('user', 'category')
            ->latest('published_at')
            ->paginate($perPage, ['*'], 'page', $page);
        
        $html = view('frontend.components.latest-posts', [
            'posts' => $posts->items(),
            'hasMorePages' => $posts->hasMorePages(),
            'nextPage' => $posts->currentPage() + 1
        ])->render();
        
        return response()->json([
            'html' => $html,
            'hasMorePages' => $posts->hasMorePages(),
            'nextPage' => $posts->currentPage() + 1
        ]);
    }

    /**
     * Get popular posts for sidebar
     */
    public function getPopularPosts()
    {
        $posts = Cache::remember('popular_posts_sidebar', 3600, function () {
            return Post::where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->withCount('likes')
                ->withCount('comments')
                ->orderBy('likes_count', 'desc')
                ->limit(4)
                ->get();
        });
        
        $html = view('frontend.components.popular-posts', [
            'posts' => $posts
        ])->render();
        
        return response()->json(['html' => $html]);
    }
}
