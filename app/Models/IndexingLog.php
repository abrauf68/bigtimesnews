<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndexingLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['site_id', 'url_id', 'type', 'level', 'message', 'context'];

    protected $casts = ['context' => 'array', 'created_at' => 'datetime'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(IndexingSite::class, 'site_id');
    }

    public static function record(?int $siteId, string $type, string $level, string $message, array $context = [], ?int $urlId = null): void
    {
        try {
            static::create([
                'site_id' => $siteId,
                'url_id' => $urlId,
                'type' => $type,
                'level' => $level,
                'message' => mb_substr($message, 0, 500),
                'context' => $context ?: null,
            ]);
        } catch (\Throwable $e) {
            // Logging must never break the work being logged.
            \Illuminate\Support\Facades\Log::warning('Indexing log write failed: ' . $e->getMessage());
        }
    }

    public function levelBadge(): string
    {
        return match ($this->level) {
            'error' => 'danger',
            'warning' => 'warning',
            default => 'info',
        };
    }
}
