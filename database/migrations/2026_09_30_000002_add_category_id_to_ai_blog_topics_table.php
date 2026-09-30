<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_blog_topics', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('country')
                    ->constrained('categories')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('ai_blog_topics', 'ai_blog_schedule_id')) {
                $table->foreignId('ai_blog_schedule_id')
                    ->nullable()
                    ->after('category_id');
            }
        });

        // FK separately
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            $table->foreign('ai_blog_schedule_id')
                ->references('id')
                ->on('ai_blog_schedules')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            if (Schema::hasColumn('ai_blog_topics', 'ai_blog_schedule_id')) {
                $table->dropForeign(['ai_blog_schedule_id']);
                $table->dropColumn('ai_blog_schedule_id');
            }

            if (Schema::hasColumn('ai_blog_topics', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};