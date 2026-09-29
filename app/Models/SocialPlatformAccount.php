<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialPlatformAccount extends Model
{
    protected $table = 'social_platform_accounts';

    protected $fillable = [
        'platform',
        'display_name',
        'external_account_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'scopes',
        'meta',
        'status',
        'health',
        'health_message',
        'is_enabled',
        'last_checked_at',
        'last_health_notified_at',
        'connected_by',
    ];

    protected $casts = [
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'scopes' => 'array',
        'meta' => 'array',
        'is_enabled' => 'boolean',
        'last_checked_at' => 'datetime',
        'last_health_notified_at' => 'datetime',
    ];

    public function connectedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'connected_by');
    }

    public function postTargets(): HasMany
    {
        return $this->hasMany(SocialPostTarget::class);
    }

    public function platformEnum(): SocialPlatform
    {
        return SocialPlatform::from($this->platform);
    }

    public function isConnected(): bool
    {
        return $this->status === 'connected' && !empty($this->access_token);
    }

    public function isHealthy(): bool
    {
        return $this->health === 'healthy';
    }

    public function isTokenExpiringSoon(int $withinMinutes = 60): bool
    {
        return $this->token_expires_at !== null
            && $this->token_expires_at->lessThan(now()->addMinutes($withinMinutes));
    }

    public function scopeUsable($query)
    {
        return $query->where('is_enabled', true)
            ->where('status', 'connected')
            ->where('health', 'healthy');
    }
}
