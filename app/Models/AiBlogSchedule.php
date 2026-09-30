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
        'is_enabled',
        'category_id',
        'trend_country',
        'last_run_date',
        'last_run_summary',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'post_count' => 'integer',
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
