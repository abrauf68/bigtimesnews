<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiBlogSetting extends Model
{
    protected $table = 'ai_blog_settings';

    protected $fillable = [
        'is_enabled',
        'daily_post_limit',
        'auto_publish',
        'run_time',
        'trends_provider',
        'trend_country',
        'trends_api_key',
        'claude_api_key',
        'claude_writer_model',
        'claude_qa_model',
        'unsplash_access_key',
        'default_category_id',
        'default_author_id',
        'posted_by_user_id',
        'notify_admin',
        'admin_email',
        'last_run_date',
        'last_summary_sent_date',
        'last_run_summary',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'auto_publish' => 'boolean',
        'notify_admin' => 'boolean',
        'last_run_date' => 'date',
        'last_summary_sent_date' => 'date',
    ];

    public function defaultCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'default_category_id');
    }

    public function defaultAuthor(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'default_author_id');
    }

    public function postedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by_user_id');
    }

    /**
     * Resolve which country codes should be queried for trends.
     * Returns an array of ISO2 codes; a "GLOBAL"/empty selection blends a
     * handful of major English-speaking markets instead of one country.
     */
    public function trendCountries(): array
    {
        $configured = $this->trend_country ? strtoupper(trim($this->trend_country)) : null;

        if ($configured && $configured !== 'GLOBAL') {
            return [$configured];
        }

        return ['US', 'GB', 'IN', 'CA', 'AU'];
    }

    public function isGlobalTrends(): bool
    {
        $configured = $this->trend_country ? strtoupper(trim($this->trend_country)) : null;
        return !$configured || $configured === 'GLOBAL';
    }

    public function resolvedAdminEmail(): ?string
    {
        if (!empty($this->admin_email)) {
            return $this->admin_email;
        }

        $company = CompanySetting::first();
        return $company->email ?? null;
    }
}
