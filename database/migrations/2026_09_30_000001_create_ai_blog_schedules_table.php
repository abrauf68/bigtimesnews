<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_blog_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('run_time');
            $table->unsignedInteger('post_count')->default(1);
            $table->boolean('is_enabled')->default(true);
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('trend_country', 10)->nullable();
            $table->date('last_run_date')->nullable();
            $table->string('last_run_summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_schedules');
    }
};
