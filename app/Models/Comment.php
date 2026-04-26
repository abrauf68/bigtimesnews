<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id',
        'status',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the post that this comment belongs to
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Get the user who wrote this comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the parent comment (for replies)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all replies to this comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->where('status', 'approved')
                    ->latest();
    }

    /**
     * Get all replies including pending
     */
    public function allReplies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Scope for approved comments only
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending comments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for spam comments
     */
    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    /**
     * Scope for trash comments
     */
    public function scopeTrash($query)
    {
        return $query->where('status', 'trash');
    }

    /**
     * Scope for top-level comments (not replies)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get comment author name
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->user && $this->user_id) {
            return $this->user->name;
        }

        return 'Guest';
    }

    /**
     * Get comment author email (if logged in)
     */
    public function getAuthorEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    /**
     * Get comment author avatar
     */
    public function getAuthorAvatarAttribute(): string
    {
        if ($this->user && $this->user->avatar) {
            return asset('storage/' . $this->user->avatar);
        }

        // Default avatar
        return asset('assets/images/default-avatar.png');
    }

    /**
     * Check if comment is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if comment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Approve the comment
     */
    public function approve(): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);
    }

    /**
     * Mark as spam
     */
    public function markAsSpam(): void
    {
        $this->update(['status' => 'spam']);
    }

    /**
     * Move to trash
     */
    public function trash(): void
    {
        $this->update(['status' => 'trash']);
    }

    /**
     * Get comment depth (for nested comments)
     */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    /**
     * Get formatted content with links
     */
    public function getFormattedContentAttribute(): string
    {
        $content = e($this->content);

        // Convert URLs to links
        $content = preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
            $content
        );

        // Convert @mentions to links
        $content = preg_replace(
            '/@([a-zA-Z0-9_]+)/',
            '<a href="/profile/$1">@$1</a>',
            $content
        );

        return nl2br($content);
    }
}
