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
                $table->unsignedBigInteger('category_id')
                    ->nullable()
                    ->after('country');
            }

            if (!Schema::hasColumn('ai_blog_topics', 'ai_blog_schedule_id')) {
                $table->unsignedBigInteger('ai_blog_schedule_id')
                    ->nullable()
                    ->after('category_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            if (Schema::hasColumn('ai_blog_topics', 'ai_blog_schedule_id')) {
                $table->dropColumn('ai_blog_schedule_id');
            }

            if (Schema::hasColumn('ai_blog_topics', 'category_id')) {
                $table->dropColumn('category_id');
            }
        });
    }
};