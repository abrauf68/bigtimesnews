<?php

namespace App\Contracts\Social;

use App\Enums\SocialPlatform;
use App\Models\Post;

interface CaptionGeneratorContract
{
    public function generate(Post $post, SocialPlatform $platform): array;
}
