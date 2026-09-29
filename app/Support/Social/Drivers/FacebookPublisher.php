<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;

class FacebookPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $pageId = $account->meta['page_id'] ?? config('social.platforms.facebook.page_id');

        $response = Http::asForm()->timeout(60)->post("https://graph.facebook.com/v19.0/{$pageId}/photos", [
            'url' => $this->imageUrl($post),
            'caption' => $target->caption,
            'access_token' => $account->access_token,
        ]);

        $this->assertSuccessful($response, 'Facebook');
        $postId = $response->json('post_id') ?? $response->json('id');

        return [
            'external_post_id' => $postId,
            'external_post_url' => $postId ? "https://www.facebook.com/{$postId}" : null,
        ];
    }
}
