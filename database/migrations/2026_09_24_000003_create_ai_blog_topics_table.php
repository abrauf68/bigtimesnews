<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_blog_topics', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->string('topic_hash')->unique(); // md5(lower(trim(topic))) - prevents re-writing the same trend
            $table->text('context')->nullable(); // related news snippet pulled alongside the trend, fed to Claude
            $table->string('country')->nullable();
            $table->enum('status', ['pending', 'generating', 'completed', 'failed'])->default('pending');
            $table->foreignId('post_id')->nullable()->constrained('posts')->nullOnDelete();
            $table->text('error_message')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_topics');
    }
};
