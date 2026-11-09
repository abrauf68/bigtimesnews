<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indexing_sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('site_url');                 // https://example.com
            $table->string('property_url');             // Search Console property: https://example.com/ or sc-domain:example.com
            $table->string('sitemap_url')->nullable();
            $table->string('google_email')->nullable();
            $table->text('access_token')->nullable();   // encrypted by the model cast
            $table->text('refresh_token')->nullable();  // encrypted by the model cast
            $table->timestamp('token_expires_at')->nullable();
            $table->string('status', 20)->default('disconnected'); // connected | disconnected
            $table->string('health', 20)->default('healthy');       // healthy | unhealthy
            $table->text('health_message')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_discover')->default(true);
            $table->unsignedInteger('daily_limit')->default(200);
            $table->time('batch_time')->default('03:00:00');
            $table->unsignedInteger('batch_size')->default(100);
            $table->unsignedInteger('reinspect_days')->default(3);
            $table->unsignedInteger('recheck_indexed_days')->default(30);
            $table->date('last_batch_date')->nullable();
            $table->timestamp('last_batch_at')->nullable();
            $table->timestamp('last_sitemap_sync_at')->nullable();
            $table->timestamp('last_sitemap_submit_at')->nullable();
            $table->unsignedInteger('sitemap_urls_found')->default(0);
            $table->timestamps();

            $table->unique('site_url');
        });

        Schema::create('indexing_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('indexing_sites')->cascadeOnDelete();
            $table->text('url');
            $table->char('url_hash', 40);
            $table->string('source', 20)->default('manual'); // sitemap | auto | manual | csv
            $table->unsignedBigInteger('post_id')->nullable();
            $table->string('status', 20)->default('pending'); // pending | indexed | not_indexed | error
            $table->string('verdict', 40)->nullable();
            $table->string('coverage_state')->nullable();
            $table->string('indexing_state', 80)->nullable();
            $table->string('robots_state', 80)->nullable();
            $table->string('page_fetch_state', 80)->nullable();
            $table->text('google_canonical')->nullable();
            $table->timestamp('last_crawl_at')->nullable();
            $table->timestamp('sitemap_lastmod')->nullable();
            $table->unsignedInteger('inspect_count')->default(0);
            $table->timestamp('inspected_at')->nullable();
            $table->timestamp('next_inspect_at')->nullable();
            $table->timestamp('first_indexed_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->unique(['site_id', 'url_hash']);
            $table->index(['site_id', 'status']);
            $table->index(['site_id', 'next_inspect_at']);
        });

        Schema::create('indexing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->nullable()->constrained('indexing_sites')->cascadeOnDelete();
            $table->unsignedBigInteger('url_id')->nullable();
            $table->string('type', 30);   // oauth | sitemap | inspect | batch | discover | import | system
            $table->string('level', 10)->default('info'); // info | warning | error
            $table->string('message', 500);
            $table->json('context')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['site_id', 'created_at']);
            $table->index(['type', 'level']);
        });

        Schema::create('indexing_api_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('indexing_sites')->cascadeOnDelete();
            $table->date('usage_date');
            $table->unsignedInteger('inspections')->default(0);
            $table->unsignedInteger('errors')->default(0);
            $table->unsignedInteger('sitemap_calls')->default(0);
            $table->timestamps();

            $table->unique(['site_id', 'usage_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indexing_api_usage');
        Schema::dropIfExists('indexing_logs');
        Schema::dropIfExists('indexing_urls');
        Schema::dropIfExists('indexing_sites');
    }
};
