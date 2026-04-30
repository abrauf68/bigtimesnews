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
            $postsQuery = Post::with('category', 'author')->withCount('comments')->where('status', 'published');

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

            $page = Page::where('page_name', 'news')->first();

            $posts = $postsQuery->latest()->paginate(3)->withQueryString();

            return view('frontend.pages.news.main', compact('posts','topCategories', 'page'));
        } catch (\Throwable $th) {
            Log::error('Error loading blogs page: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the blogs page.');
        }
    }
}
