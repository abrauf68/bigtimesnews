<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $totalUsers = User::count();
        $totalViews = Post::sum('views');
        $totalLikes = PostLike::count();

        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->toDateString());

        $likesByDay = PostLike::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $commentsByDay = Comment::where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $trendLabels = $days->map(fn($d) => \Carbon\Carbon::parse($d)->format('D'))->values();
        $trendLikes = $days->map(fn($d) => (int) ($likesByDay[$d] ?? 0))->values();
        $trendComments = $days->map(fn($d) => (int) ($commentsByDay[$d] ?? 0))->values();

        $categorySplit = Category::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(6)
            ->get(['id', 'name']);

        $latestPosts = Post::with('category')
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(5)
            ->get();

        $topLikedPosts = Post::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get(['id', 'title']);
        $topLikedMax = $topLikedPosts->max('likes_count') ?: 1;

        return view('dashboard.index', compact(
            'totalPosts',
            'totalUsers',
            'totalViews',
            'totalLikes',
            'trendLabels',
            'trendLikes',
            'trendComments',
            'categorySplit',
            'latestPosts',
            'topLikedPosts',
            'topLikedMax'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
