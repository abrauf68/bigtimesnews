<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class IndexingSite extends Model
{
    protected $fillable = [
        'name', 'site_url', 'property_url', 'sitemap_url', 'google_email',
        'access_token', 'refresh_token', 'token_expires_at', 'status', 'health', 'health_message',
        'is_active', 'auto_discover', 'daily_limit', 'batch_time', 'batch_size',
        'reinspect_days', 'recheck_indexed_days',
        'last_batch_date', 'last_batch_at', 'last_sitemap_sync_at', 'last_sitemap_submit_at', 'sitemap_urls_found',
    ];

    // Tokens are encrypted at rest with the app key and never sent to the browser.
    protected $casts = [
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'auto_discover' => 'boolean',
        'last_batch_date' => 'date',
        'last_batch_at' => 'datetime',
        'last_sitemap_sync_at' => 'datetime',
        'last_sitemap_submit_at' => 'datetime',
    ];

    protected $hidden = ['access_token', 'refresh_token'];

    public function urls(): HasMany
    {
        return $this->hasMany(IndexingUrl::class, 'site_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(IndexingLog::class, 'site_id');
    }

    public function usage(): HasMany
    {
        return $this->hasMany(IndexingApiUsage::class, 'site_id');
    }

    public function isConnected(): bool
    {
        return $this->status === 'connected' && !empty($this->refresh_token);
    }

    public function isHealthy(): bool
    {
        return $this->health === 'healthy';
    }

    public function host(): string
    {
        return strtolower((string) parse_url($this->site_url, PHP_URL_HOST));
    }

    public function effectiveDailyLimit(): int
    {
        return min((int) $this->daily_limit, (int) config('google_indexing.daily_hard_cap', 2000));
    }

    /** Batch time as "H:i" regardless of how the driver returns TIME columns. */
    public function batchTimeShort(): string
    {
        return substr((string) $this->batch_time, 0, 5);
    }

    /** True when the URL belongs to this site's Search Console property. */
    public function ownsUrl(string $url): bool
    {
        $property = (string) $this->property_url;

        if (Str::startsWith($property, 'sc-domain:')) {
            $domain = strtolower(substr($property, 10));
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));

            return $host === $domain || Str::endsWith($host, '.' . $domain);
        }

        return Str::startsWith(strtolower($url), strtolower($property));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
