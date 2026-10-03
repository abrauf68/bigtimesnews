<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tracks every Unsplash photo used across all posts (featured + inline
        // content images) so UnsplashService can avoid reusing a photo until
        // it has aged out of the most recent 200 uses.
        Schema::create('ai_blog_used_images', function (Blueprint $table) {
            $table->id();
            $table->string('photo_id')->index();
            $table->timestamp('used_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_blog_used_images');
    }
};
