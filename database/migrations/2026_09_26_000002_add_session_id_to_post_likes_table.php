<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('user_id');
            $table->unique(['post_id', 'session_id'], 'post_likes_post_id_session_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropUnique('post_likes_post_id_session_id_unique');
            $table->dropColumn('session_id');
        });
    }
};
