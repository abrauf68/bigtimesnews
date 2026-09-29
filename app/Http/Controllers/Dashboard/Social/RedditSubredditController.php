<?php

namespace App\Http\Controllers\Dashboard\Social;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\RedditAllowedSubreddit;
use Illuminate\Http\Request;

class RedditSubredditController extends Controller
{
    public function index()
    {
        $subreddits = RedditAllowedSubreddit::with('category')->latest()->get();
        $categories = Category::where('is_active', 'active')->orderBy('name')->get();

        return view('dashboard.social.subreddits.index', compact('subreddits', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:reddit_allowed_subreddits,name',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        RedditAllowedSubreddit::create([
            'name' => ltrim(trim($request->name), 'r/'),
            'category_id' => $request->category_id,
            'is_approved' => false,
        ]);

        return redirect()->route('dashboard.social.subreddits.index')->with('success', 'Subreddit added, pending approval.');
    }

    public function approve(RedditAllowedSubreddit $subreddit)
    {
        $subreddit->update([
            'is_approved' => true,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Subreddit approved.');
    }

    public function destroy(RedditAllowedSubreddit $subreddit)
    {
        $subreddit->delete();

        return redirect()->back()->with('success', 'Subreddit removed.');
    }
}
