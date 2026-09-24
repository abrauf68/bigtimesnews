<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('source', ['manual', 'ai'])->default('manual')->after('user_id');
            $table->foreignId('ai_blog_topic_id')->nullable()->after('source')
                ->constrained('ai_blog_topics')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ai_blog_topic_id');
            $table->dropColumn('source');
        });
    }
};
