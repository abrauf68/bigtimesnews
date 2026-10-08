<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /** Latest published posts, used for plain crawlable link lists. */
    private function latestLinks(int $limit = 20, ?int $exceptId = null, ?int $categoryId = null)
    {
        return Post::with('category:id,name,slug')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest('published_at')
            ->limit($limit)
            ->get(['id', 'title', 'slug', 'category_id', 'published_at']);
    }

    public function home()
    {
        try {
            $page = Page::where('page_name', 'home')->first();
            $latestLinks = $this->latestLinks(20);
            return view('frontend.pages.home', compact('page', 'latestLinks'));
        } catch (\Throwable $th) {
            Log::error('Home Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            // throw $th;
        }
    }

    public function newsletterStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $newsletter = Newsletter::where('email', $request->email)->first();
            if ($newsletter) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already subscribed to our newsletter.'
                ]);
            }
            $newsletter = new Newsletter();
            $newsletter->email = $request->email;
            $newsletter->save();

            return response()->json([
                'success' => true,
                'message' => 'Thanks for subscribing!'
            ]);
        } catch (\Throwable $th) {
            Log::error('NewsLetter Store Failed', ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again later'
            ]);
            // throw $th;
        }
    }

    public function postDetail($categorySlug = null, $postSlug = null)
    {
        try {
            if($categorySlug && $postSlug)
            {
                $category = Category::where('slug', $categorySlug)->first();
                if(!$category) {
                    abort(404);
                }

                // Get the main post ONLY - lightweight query
                $post = Post::with('category:id,name,slug', 'author', 'faqs')
                    ->where('slug', $postSlug)
                    ->where('category_id', $category->id)
                    ->where('status', 'published')
                    ->firstOrFail();

                // Increment views
                if (!preg_match('/bot|crawl|spider|slurp|bing|yandex|facebookexternalhit/i', (string) request()->userAgent())) {
                    $post->increment('views');
                }

                // Get top categories for sidebar (lightweight)
                $topCategories = Category::withCount('posts')
                    ->orderBy('posts_count', 'desc')
                    ->limit(5)
                    ->get();

                $sameCategoryLinks = $this->latestLinks(8, $post->id, $post->category_id);
                $latestLinks = $this->latestLinks(8, $post->id);
                $prevLink = Post::with('category:id,name,slug')->where('status', 'published')
                    ->where('category_id', $post->category_id)->where('id', '<', $post->id)
                    ->orderByDesc('id')->first(['id', 'title', 'slug', 'category_id']);
                $nextLink = Post::with('category:id,name,slug')->where('status', 'published')
                    ->where('category_id', $post->category_id)->where('id', '>', $post->id)
                    ->orderBy('id')->first(['id', 'title', 'slug', 'category_id']);

                return view('frontend.pages.news.single-post', compact('post', 'category', 'topCategories', 'sameCategoryLinks', 'latestLinks', 'prevLink', 'nextLink'));
            }
            $postsQuery = Post::with('category:id,name,slug', 'author')->withCount('comments')->where('status', 'published');

            if (request()->filled('search')) {
                $search = request('search');
                $postsQuery->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            }

            if($categorySlug && !$postSlug)
            {
                $category = Category::where('slug', $categorySlug)->first();
                if($category)
                {
                    $posts = $postsQuery->where('category_id', $category->id)->latest()->limit(5)->get();
                    $latestLinks = $this->latestLinks(20, null, $category->id);
                    return view('frontend.pages.news.single-category', compact('category', 'posts', 'latestLinks'));
                }
            }

            $page = Page::where('page_name', 'news')->first();

            $posts = $postsQuery->latest()->paginate(3)->withQueryString();

            $latestLinks = $this->latestLinks(20);
            return view('frontend.pages.news.main', compact('posts', 'page', 'latestLinks'));
        } catch (\Illuminate\Http\Exceptions\HttpResponseException|\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface|\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            throw $th; // real 404s stay 404s for Google
        } catch (\Throwable $th) {
            Log::error('Error loading blogs page: ' . $th->getMessage());
            abort(500, 'An error occurred while loading the page.');
        }
    }
}
