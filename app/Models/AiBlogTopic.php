<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AiBlogTopic extends Model
{
    protected $table = 'ai_blog_topics';

    protected $fillable = [
        'topic',
        'topic_hash',
        'context',
        'country',
        'status',
        'post_id',
        'error_message',
        'fetched_at',
    ];

    protected $casts = [
        'fetched_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public static function hashFor(string $topic): string
    {
        return md5(Str::lower(trim($topic)));
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }
}
