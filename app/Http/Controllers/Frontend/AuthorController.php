<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Post;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function show(int $id, ?string $slug = null)
    {
        $author = Author::where('id', $id)->where('is_active', 'active')->firstOrFail();

        // Canonical URL: redirect if the slug is missing or wrong.
        $canonicalSlug = Str::slug($author->name) ?: 'author';
        if ($slug !== $canonicalSlug) {
            return redirect()->route('frontend.author', ['id' => $author->id, 'slug' => $canonicalSlug], 301);
        }

        $posts = Post::with('category:id,name,slug')
            ->where('author_id', $author->id)
            ->where('status', 'published')
            ->whereHas('category')
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('frontend.pages.static.author', compact('author', 'posts'));
    }
}
