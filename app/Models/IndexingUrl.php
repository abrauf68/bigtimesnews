<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndexingUrl extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_INDEXED = 'indexed';
    public const STATUS_NOT_INDEXED = 'not_indexed';
    public const STATUS_ERROR = 'error';

    public const STATUSES = [self::STATUS_PENDING, self::STATUS_INDEXED, self::STATUS_NOT_INDEXED, self::STATUS_ERROR];
    public const SOURCES = ['sitemap', 'auto', 'manual', 'csv'];

    protected $fillable = [
        'site_id', 'url', 'url_hash', 'source', 'post_id', 'status', 'verdict', 'coverage_state',
        'indexing_state', 'robots_state', 'page_fetch_state', 'google_canonical', 'last_crawl_at',
        'sitemap_lastmod', 'inspect_count', 'inspected_at', 'next_inspect_at', 'first_indexed_at', 'last_error',
    ];

    protected $casts = [
        'last_crawl_at' => 'datetime',
        'sitemap_lastmod' => 'datetime',
        'inspected_at' => 'datetime',
        'next_inspect_at' => 'datetime',
        'first_indexed_at' => 'datetime',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(IndexingSite::class, 'site_id');
    }

    public static function hashUrl(string $url): string
    {
        return sha1($url);
    }

    /** Search Console home for this site's property. Google does not publish a deep link that pre-fills the inspected URL. */
    public function searchConsoleLink(): string
    {
        return 'https://search.google.com/search-console?' . http_build_query(['resource_id' => $this->site?->property_url]);
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            self::STATUS_INDEXED => 'success',
            self::STATUS_NOT_INDEXED => 'danger',
            self::STATUS_ERROR => 'warning',
            default => 'secondary',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_INDEXED => 'Indexed',
            self::STATUS_NOT_INDEXED => 'Not Indexed',
            self::STATUS_ERROR => 'Error',
            default => 'Pending',
        };
    }
}
