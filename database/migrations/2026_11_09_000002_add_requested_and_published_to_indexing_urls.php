<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('indexing_urls', function (Blueprint $table) {
            $table->timestamp('requested_at')->nullable()->after('first_indexed_at'); // manual "Request indexing" click
            $table->timestamp('published_at')->nullable()->after('requested_at');    // the blog post's publish date
            $table->index(['site_id', 'published_at']);
        });

        // Fill the post date for URLs that already exist.
        try {
            app(\App\Services\GoogleIndexing\PostDateResolver::class)->backfill();
        } catch (\Throwable $e) {
            // Non-fatal: run `php artisan google-indexing:backfill-post-dates` afterwards.
        }
    }

    public function down(): void
    {
        Schema::table('indexing_urls', function (Blueprint $table) {
            $table->dropIndex(['site_id', 'published_at']);
            $table->dropColumn(['requested_at', 'published_at']);
        });
    }
};
