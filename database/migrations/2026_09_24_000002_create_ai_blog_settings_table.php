<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_blog_settings', function (Blueprint $table) {
            $table->id();

            // Master switch
            $table->boolean('is_enabled')->default(false);

            // How many posts to generate per day + publish behaviour
            $table->unsignedTinyInteger('daily_post_limit')->default(3);
            $table->boolean('auto_publish')->default(false); // false = save as draft
            $table->time('run_time')->default('03:00:00'); // server time the daily run should fire

            // Trend source
            $table->string('trends_provider')->default('google_trends'); // google_trends (free) | serpapi
            $table->string('trend_country')->nullable(); // ISO2 e.g. "US", null/"GLOBAL" = worldwide blend
            $table->string('trends_api_key')->nullable(); // only needed for paid providers like serpapi

            // AI writer keys/models
            $table->text('claude_api_key')->nullable();
            $table->string('claude_writer_model')->default('claude-sonnet-5');
            $table->string('claude_qa_model')->default('claude-haiku-4-5-20251001');

            // Images
            $table->string('unsplash_access_key')->nullable();

            // Defaults used when creating the generated posts
            $table->foreignId('default_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('default_author_id')->nullable()->constrained('authors')->nullOnDelete();
            $table->foreignId('posted_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Admin notification
            $table->boolean('notify_admin')->default(true);
            $table->string('admin_email')->nullable();

            // Run bookkeeping
            $table->date('last_run_date')->nullable();
            $table->date('last_summary_sent_date')->nullable();
            $table->text('last_run_summary')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_settings');
    }
};
