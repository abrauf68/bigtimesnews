<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;

class InstagramPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $igUserId = $account->meta['ig_business_account_id'] ?? null;

        $create = Http::asForm()->timeout(60)->post("https://graph.facebook.com/v19.0/{$igUserId}/media", [
            'image_url' => $this->imageUrl($post),
            'caption' => $target->caption,
            'access_token' => $account->access_token,
        ]);
        $this->assertSuccessful($create, 'Instagram');
        $creationId = $create->json('id');

        $publish = Http::asForm()->timeout(60)->post("https://graph.facebook.com/v19.0/{$igUserId}/media_publish", [
            'creation_id' => $creationId,
            'access_token' => $account->access_token,
        ]);
        $this->assertSuccessful($publish, 'Instagram');
        $mediaId = $publish->json('id');

        return [
            'external_post_id' => $mediaId,
            'external_post_url' => null,
        ];
    }
}
