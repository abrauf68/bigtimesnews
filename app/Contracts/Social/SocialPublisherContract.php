<?php

namespace App\Contracts\Social;

use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;

interface SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array;
}
