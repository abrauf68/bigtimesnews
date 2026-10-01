<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;

class XPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $imageBytes = Http::timeout(30)->get($this->imageUrl($post))->body();
        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->buffer($imageBytes) ?: 'image/jpeg';

        $mediaResponse = Http::withToken($account->access_token)
            ->asMultipart()
            ->attach('media', $imageBytes, 'image.jpg')
            ->timeout(60)
            ->post('https://api.x.com/2/media/upload', [
                'media_category' => 'tweet_image',
                'media_type' => $mimeType,
            ]);

        $this->assertSuccessful($mediaResponse, 'X');
        $mediaId = $mediaResponse->json('data.id') ?? $mediaResponse->json('id');

        $payload = ['text' => $target->caption];
        if ($mediaId) {
            $payload['media'] = ['media_ids' => [(string) $mediaId]];
        }

        $tweetResponse = Http::withToken($account->access_token)
            ->timeout(30)
            ->post('https://api.x.com/2/tweets', $payload);

        $this->assertSuccessful($tweetResponse, 'X');
        $tweetId = $tweetResponse->json('data.id');

        return [
            'external_post_id' => $tweetId,
            'external_post_url' => $tweetId ? "https://x.com/i/web/status/{$tweetId}" : null,
        ];
    }
}