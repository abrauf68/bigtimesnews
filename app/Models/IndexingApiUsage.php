<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexingApiUsage extends Model
{
    protected $table = 'indexing_api_usage';

    protected $fillable = ['site_id', 'usage_date', 'inspections', 'errors', 'sitemap_calls'];

    protected $casts = ['usage_date' => 'date'];

    public static function today(int $siteId): self
    {
        return static::firstOrCreate(['site_id' => $siteId, 'usage_date' => now()->toDateString()]);
    }

    public static function inspectionsToday(int $siteId): int
    {
        return (int) static::where('site_id', $siteId)->whereDate('usage_date', now()->toDateString())->value('inspections');
    }

    /** Atomically add to a usage counter for today. */
    public static function bump(int $siteId, string $column, int $by = 1): void
    {
        static::today($siteId)->increment($column, $by);
    }
}
