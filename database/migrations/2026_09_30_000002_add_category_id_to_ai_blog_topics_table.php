<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('country')->constrained('categories')->nullOnDelete();
            $table->foreignId('ai_blog_schedule_id')->nullable()->after('category_id')->constrained('ai_blog_schedules')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ai_blog_topics', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('ai_blog_schedule_id');
        });
    }
};
