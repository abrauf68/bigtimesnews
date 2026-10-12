<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_blog_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_blog_schedules', 'trend_count')) {
                $table->unsignedInteger('trend_count')->default(0)->after('post_count');
            }
            if (!Schema::hasColumn('ai_blog_schedules', 'upcoming_count')) {
                $table->unsignedInteger('upcoming_count')->default(0)->after('trend_count');
            }
            if (!Schema::hasColumn('ai_blog_schedules', 'evergreen_count')) {
                $table->unsignedInteger('evergreen_count')->default(0)->after('upcoming_count');
            }
        });

        // Existing slots keep behaving exactly as before: all their posts are trend posts.
        DB::table('ai_blog_schedules')
            ->where('trend_count', 0)->where('upcoming_count', 0)->where('evergreen_count', 0)
            ->update(['trend_count' => DB::raw('post_count')]);

        Schema::table('ai_blog_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_blog_topics', 'type')) {
                $table->string('type', 20)->default('trend')->after('topic_hash');
            }
            if (!Schema::hasColumn('ai_blog_topics', 'source_key')) {
                $table->string('source_key')->nullable()->after('type');
            }
        });

        if (!Schema::hasTable('ai_blog_events')) {
            Schema::create('ai_blog_events', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->date('event_date');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_events');

        Schema::table('ai_blog_topics', function (Blueprint $table) {
            foreach (['source_key', 'type'] as $col) {
                if (Schema::hasColumn('ai_blog_topics', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('ai_blog_schedules', function (Blueprint $table) {
            foreach (['evergreen_count', 'upcoming_count', 'trend_count'] as $col) {
                if (Schema::hasColumn('ai_blog_schedules', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
