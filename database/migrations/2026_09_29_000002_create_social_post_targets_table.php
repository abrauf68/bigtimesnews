<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_post_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->enum('platform', ['x', 'facebook', 'instagram', 'linkedin', 'pinterest', 'tumblr', 'reddit']);
            $table->foreignId('social_platform_account_id')->nullable()->constrained('social_platform_accounts')->nullOnDelete();
            $table->boolean('is_enabled')->default(true);
            $table->enum('status', ['pending', 'queued', 'posted', 'failed', 'skipped'])->default('pending');
            $table->text('caption')->nullable();
            $table->enum('caption_source', ['generated', 'fallback', 'manual'])->nullable();
            $table->string('external_post_id')->nullable();
            $table->string('external_post_url')->nullable();
            $table->text('error_message')->nullable();
            $table->text('skip_reason')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('last_attempted_at')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();

            $table->unique(['post_id', 'platform']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_post_targets');
    }
};
