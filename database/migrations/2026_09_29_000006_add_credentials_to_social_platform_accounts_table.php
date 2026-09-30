<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_platform_accounts', function (Blueprint $table) {
            $table->string('client_id')->nullable()->after('platform');
            $table->text('client_secret')->nullable()->after('client_id');
            $table->json('settings')->nullable()->after('client_secret');
        });
    }

    public function down(): void
    {
        Schema::table('social_platform_accounts', function (Blueprint $table) {
            $table->dropColumn(['client_id', 'client_secret', 'settings']);
        });
    }
};
