<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'author_id',
        'category_id',
        'title',
        'slug',
        'read_time',
        'meta_image',
        'main_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'tags',
        'status',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Existing relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Add likes relationship
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    // Get likes count
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Get top posts by likes for current month
    public function scopeTopPostsThisMonth($query, $limit = 10)
    {
        return $query->published()
            ->whereMonth('published_at', now()->month)
            ->whereYear('published_at', now()->year)
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->limit($limit);
    }

    /**
     * Scope for featured slider posts (most liked from last 30 days)
     */
    public function scopeFeaturedSlider($query, $limit = 4)
    {
        return $query->published()
            ->where('published_at', '>=', now()->subDays(30))
            ->withCount('likes')
            ->withCount('comments')
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->limit($limit);
    }
    
    /**
     * Scope for most liked all time
     */
    public function scopeMostLiked($query, $limit = 10)
    {
        return $query->published()
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->limit($limit);
    }
    
    /**
     * Scope for trending posts (likes + comments)
     */
    public function scopeTrending($query, $limit = 10)
    {
        return $query->published()
            ->where('published_at', '>=', now()->subDays(7))
            ->withCount('likes')
            ->withCount('comments')
            ->orderByRaw('(likes_count + comments_count) desc')
            ->limit($limit);
    }
    
    /**
     * Scope for posts by category
     */
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    /**
     * Scope for hot now posts (most liked + commented from last 7 days)
     */
    public function scopeHotNow($query, $limit = 10)
    {
        return $query->published()
            ->where('published_at', '>=', now()->subDays(30)) // Extended to 30 days
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->orderBy('published_at', 'desc') // If likes are equal, show newer ones
            ->limit($limit);
    }

    /**
     * Scope for posts by category slug
     */
    public function scopeByCategorySlug($query, $slug)
    {
        return $query->whereHas('category', function($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    /**
     * Scope for featured posts (for main section)
     */
    public function scopeFeatured($query, $limit = 4)
    {
        return $query->published()
            ->withCount('likes')
            ->withCount('comments')
            ->latest('published_at')
            ->limit($limit);
    }
}
