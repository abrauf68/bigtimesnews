<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
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
            $posts = Post::with('category:id,name,slug', 'author')->where('status', 'published')
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
            $posts = Post::with('category:id,name,slug', 'author')->where('status', 'published')
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
        $posts = Post::with('category:id,name,slug', 'author')->hotNow(10)->get();

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

        $posts = Post::with('category:id,name,slug', 'author')->where('status', 'published')
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
            return Post::with('category:id,name,slug', 'author')->where('status', 'published')
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





    /**
     * NEW METHOD: Get all categories with their sections
     */
    public function getCategorySections()
    {
        try {
            $categories = Category::where('is_active', 'active')
                ->withCount(['posts' => function($q) {
                    $q->published();
                }])
                ->having('posts_count', '>=', 6)
                ->orderBy('name')
                // ->take(6)
                ->get();

            $html = view('frontend.components.new-category-sections', [
                'categories' => $categories
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * NEW METHOD: Get posts for infinite scroll by category
     */
    public function getCategoryPostsInfinite(Request $request, $slug)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = 5;

            $category = Category::where('slug', $slug)
                ->where('is_active', 'active')
                ->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $posts = $category->posts()
                ->published()
                ->with(['author', 'category'])
                ->withCount('comments')
                ->latest('published_at')
                ->paginate($perPage, ['*'], 'page', $page);

            $html = view('frontend.components.new-category-posts', [
                'posts' => $posts->items(),
                'category' => $category,
                'page' => $page
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'hasMorePages' => $posts->hasMorePages(),
                'nextPage' => $posts->currentPage() + 1
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get related posts for second section (based on current category)
     */
    public function getRelatedCategoryPosts(Request $request, $slug)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = 6;

            $currentCategory = Category::where('slug', $slug)
                ->where('is_active', 'active')
                ->first();

            if (!$currentCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $posts = $currentCategory->posts()
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->with(['author', 'category'])
                ->withCount('comments')
                ->latest('published_at')
                ->paginate($perPage, ['*'], 'page', $page);

            // Force hasMorePages to be true if there are more posts
            $hasMorePages = $posts->hasMorePages();

            Log::info("Category: {$slug}, Page: {$page}, Total: {$posts->total()}, HasMore: {$hasMorePages}");

            $html = view('frontend.components.category-related-posts-grid', [
                'posts' => $posts->items(),
                'category' => $currentCategory
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'hasMorePages' => $hasMorePages,
                'nextPage' => $posts->currentPage() + 1,
                'total' => $posts->total(),
                'currentPage' => $posts->currentPage(),
                'perPage' => $perPage
            ]);
        } catch (\Throwable $e) {
            Log::error('Error in getRelatedCategoryPosts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get most watched posts for sidebar
     */
    public function getMostWatchedPosts(Request $request)
    {
        try {
            $categorySlug = $request->get('category_slug');

            $query = Post::with('category:id,name,slug', 'author')->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->with(['author', 'category'])
                ->withCount(['comments', 'likes'])
                ->orderByRaw('COALESCE(comments_count, 0) + COALESCE(likes_count, 0) DESC')
                ->limit(5);

            if ($categorySlug) {
                $query->whereHas('category', function($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            $posts = $query->get();

            Log::info("Most watched posts for {$categorySlug}: " . $posts->count());

            $html = view('frontend.components.category-most-watched', [
                'posts' => $posts
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Throwable $e) {
            Log::error('Error in getMostWatchedPosts: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }




    /**
     * Get prev/next posts for AJAX loading
     */
    public function getPostNavigation($postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $prevPost = Post::where('status', 'published')
                ->where('id', '<', $postId)
                ->where('category_id', $post->category_id)
                ->orderBy('id', 'desc')
                ->first();

            $nextPost = Post::where('status', 'published')
                ->where('id', '>', $postId)
                ->where('category_id', $post->category_id)
                ->orderBy('id', 'asc')
                ->first();

            $prevHtml = $prevPost ? view('frontend.components.post-navigation-item', ['post' => $prevPost, 'type' => 'prev'])->render() : '';
            $nextHtml = $nextPost ? view('frontend.components.post-navigation-item', ['post' => $nextPost, 'type' => 'next'])->render() : '';

            return response()->json([
                'success' => true,
                'prev_html' => $prevHtml,
                'next_html' => $nextHtml,
                'has_prev' => !is_null($prevPost),
                'has_next' => !is_null($nextPost)
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get related posts for AJAX loading
     */
    public function getRelatedPosts($postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $relatedPosts = Post::where('status', 'published')
                ->where('id', '!=', $postId)
                ->where('category_id', $post->category_id)
                ->withCount('comments')
                ->latest('published_at')
                ->limit(4)
                ->get();

            $html = view('frontend.components.related-posts-grid', ['posts' => $relatedPosts])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $relatedPosts->count()
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get comments for AJAX loading
     */
    public function getPostComments($postId)
    {
        try {
            $post = Post::findOrFail($postId);

            $comments = $post->comments()
                ->with('user')
                ->where('status', 'approved')
                ->latest()
                ->paginate(10);

            $html = view('frontend.components.post-comments', [
                'comments' => $comments,
                'post' => $post
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $comments->total(),
                'has_more' => $comments->hasMorePages(),
                'next_page' => $comments->currentPage() + 1
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Load more comments (pagination)
     */
    public function loadMoreComments(Request $request, $postId)
    {
        try {
            $page = $request->get('page', 1);

            $comments = Comment::where('post_id', $postId)
                ->with('user')
                ->where('status', 'approved')
                ->latest()
                ->paginate(10, ['*'], 'page', $page);

            $html = view('frontend.components.comments-list', ['comments' => $comments->items()])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'has_more' => $comments->hasMorePages(),
                'next_page' => $comments->currentPage() + 1
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Submit comment via AJAX
     */
    public function submitComment(Request $request, $postId)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required|string|min:3'
            ]);

            $comment = Comment::create([
                'post_id' => $postId,
                'user_name' => $request->name,
                'user_email' => $request->email,
                'content' => $request->comment,
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment submitted successfully and awaiting moderation.',
                'comment' => $comment
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
