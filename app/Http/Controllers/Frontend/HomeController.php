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
    public function home()
    {
        try {
            $page = Page::where('page_name', 'home')->first();
            return view('frontend.pages.home', compact('page'));
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

    public function postDetail($slug = null)
    {
        try {
            $postsQuery = Post::with('category', 'author')->where('status', 'published');

            if (request()->filled('search')) {
                $search = request('search');
                $postsQuery->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            }

            $topCategories = Category::withCount(['posts' => function ($query) {
                    $query->where('status', 'published');
                }])->orderByDesc('posts_count')->take(5)->get();

            $allTags = Post::where('status', 'published')
                ->pluck('tags')
                ->filter()
                ->map(fn($tag) => json_decode($tag, true))
                ->flatten()
                ->filter()
                ->map(fn($tag) => trim($tag));

            $topTags = $allTags->countBy()->sortDesc()->take(10);

            $page = Page::where('page_name', 'blogs')->first();

            if ($slug) {
                $Category = BlogCategory::where('slug', $categorySlug)->firstOrFail();

                $blog = Blog::with('user.profile:id,user_id,profile_image','blogComments', 'blogCategory')->withCount('blogComments')->where('slug', $blogSlug)
                    ->where('blog_category_id', $blogCategory->id)
                    ->where('is_active', 'active')
                    ->firstOrFail();

                $nextBlog = Blog::with('blogCategory')
                    ->where('id', '>', $blog->id)
                    ->where('is_active', 'active')
                    ->orderBy('id')
                    ->first();

                if (!$nextBlog) {
                    $nextBlog = Blog::with('blogCategory')->where('is_active', 'active')->first();
                }

                $previousBlog = Blog::with('blogCategory')
                    ->where('id', '<', $blog->id)
                    ->where('is_active', 'active')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$previousBlog) {
                    $previousBlog = Blog::with('blogCategory')->where('is_active', 'active')->orderBy('id', 'desc')->first();
                }

                $relatedBlogs = Blog::with('blogCategory', 'user')
                    ->where('blog_category_id', $blog->blog_category_id)
                    ->where('id', '!=', $blog->id)
                    ->where('is_active', 'active')
                    ->latest()
                    ->take(3)
                    ->get();

                $randomQuote = Quote::inRandomOrder()->first();

                $blogComments = BlogComment::with('user')->where('blog_id', $blog->id)->where('is_active', 'active')->latest()->get();

                return view('frontend.pages.blog.blog-details', compact('blog','nextBlog','previousBlog','relatedBlogs','topTags','topCategories','randomQuote','blogComments'));
            }

            $blogs = $blogsQuery->latest()->paginate(3)->withQueryString();

            $relatedBlogs = Blog::with('blogCategory', 'user')
                ->where('is_active', 'active')
                ->latest()
                ->take(3)
                ->get();

            return view('frontend.pages.blog.blogs', compact('blogs','topTags','topCategories','relatedBlogs','page'));
        } catch (\Throwable $th) {
            Log::error('Error loading blogs page: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the blogs page.');
        }
    }
}
