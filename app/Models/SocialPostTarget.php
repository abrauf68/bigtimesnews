<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialPostTarget extends Model
{
    protected $table = 'social_post_targets';

    protected $fillable = [
        'post_id',
        'platform',
        'social_platform_account_id',
        'is_enabled',
        'status',
        'caption',
        'caption_title',
        'caption_source',
        'external_post_id',
        'external_post_url',
        'error_message',
        'skip_reason',
        'attempts',
        'last_attempted_at',
        'posted_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'attempts' => 'integer',
        'last_attempted_at' => 'datetime',
        'posted_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(SocialPlatformAccount::class, 'social_platform_account_id');
    }

    public function platformEnum(): SocialPlatform
    {
        return SocialPlatform::from($this->platform);
    }

    public function isRetryable(): bool
    {
        return in_array($this->status, ['failed', 'pending', 'skipped'], true);
    }
}
