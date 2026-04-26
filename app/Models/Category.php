<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'string',
    ];

    /**
     * Category ke saare posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    /**
     * Sirf published posts
     */
    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id')
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Active categories ke liye scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 'active');
    }
}
