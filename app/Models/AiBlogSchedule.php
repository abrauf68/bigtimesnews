<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiBlogSchedule extends Model
{
    protected $table = 'ai_blog_schedules';

    protected $fillable = [
        'run_time',
        'post_count',
        'trend_count',
        'upcoming_count',
        'evergreen_count',
        'is_enabled',
        'category_id',
        'trend_country',
        'last_run_date',
        'last_run_summary',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'post_count' => 'integer',
        'trend_count' => 'integer',
        'upcoming_count' => 'integer',
        'evergreen_count' => 'integer',
        'last_run_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(AiBlogTopic::class);
    }

    /**
     * Posts to generate per content type for this slot. Rows created before the
     * per-type columns existed fall back to treating post_count as trend posts.
     */
    public function countsByType(): array
    {
        $counts = [
            'trend' => (int) $this->trend_count,
            'upcoming' => (int) $this->upcoming_count,
            'evergreen' => (int) $this->evergreen_count,
        ];

        if (array_sum($counts) === 0 && (int) $this->post_count > 0) {
            $counts['trend'] = (int) $this->post_count;
        }

        return $counts;
    }

    public function totalPosts(): int
    {
        return array_sum($this->countsByType());
    }

    public function hasRunToday(): bool
    {
        return $this->last_run_date !== null && $this->last_run_date->toDateString() === now()->toDateString();
    }

    public function isDue(): bool
    {
        if ($this->hasRunToday()) {
            return false;
        }

        $configuredTime = now()->createFromFormat('H:i:s', $this->run_time);

        return now()->gte($configuredTime);
    }

    public function formattedTime(): string
    {
        return now()->createFromFormat('H:i:s', $this->run_time)->format('H:i');
    }
}
