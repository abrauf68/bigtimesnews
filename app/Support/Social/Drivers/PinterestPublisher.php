<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;

class PinterestPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $boardId = $account->meta['board_id'] ?? config('social.platforms.pinterest.board_id');

        $response = Http::withToken($account->access_token)->timeout(60)->post('https://api.pinterest.com/v5/pins', [
            'board_id' => $boardId,
            'title' => $target->caption_title ?: $post->meta_title,
            'description' => $target->caption,
            'link' => $this->postLink($post),
            'media_source' => [
                'source_type' => 'image_url',
                'url' => $this->imageUrl($post),
            ],
        ]);
        $this->assertSuccessful($response, 'Pinterest');
        $pinId = $response->json('id');

        return [
            'external_post_id' => $pinId,
            'external_post_url' => $pinId ? "https://www.pinterest.com/pin/{$pinId}" : null,
        ];
    }
}
