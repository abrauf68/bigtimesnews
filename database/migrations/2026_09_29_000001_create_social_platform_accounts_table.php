<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_platform_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['x', 'facebook', 'instagram', 'linkedin', 'pinterest', 'tumblr', 'reddit'])->unique();
            $table->string('display_name')->nullable();
            $table->string('external_account_id')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('scopes')->nullable();
            $table->json('meta')->nullable();
            $table->enum('status', ['disconnected', 'connected'])->default('disconnected');
            $table->enum('health', ['healthy', 'unhealthy'])->default('healthy');
            $table->text('health_message')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('last_health_notified_at')->nullable();
            $table->foreignId('connected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_platform_accounts');
    }
};
