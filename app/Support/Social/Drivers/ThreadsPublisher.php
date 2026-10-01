<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ThreadsPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    private const BASE = 'https://graph.threads.net/v1.0';

    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $userId = $account->external_account_id ?: ($account->meta['threads_user_id'] ?? 'me');

        $create = Http::asForm()->timeout(60)->post(self::BASE . "/{$userId}/threads", [
            'media_type' => 'IMAGE',
            'image_url' => $this->imageUrl($post),
            'text' => $target->caption,
            'access_token' => $account->access_token,
        ]);
        $this->assertSuccessful($create, 'Threads');
        $creationId = $create->json('id');

        $this->waitUntilReady($creationId, $account->access_token);

        $publish = Http::asForm()->timeout(60)->post(self::BASE . "/{$userId}/threads_publish", [
            'creation_id' => $creationId,
            'access_token' => $account->access_token,
        ]);
        $this->assertSuccessful($publish, 'Threads');
        $mediaId = $publish->json('id');

        $permalink = Http::timeout(30)->get(self::BASE . "/{$mediaId}", [
            'fields' => 'permalink',
            'access_token' => $account->access_token,
        ])->json('permalink');

        return [
            'external_post_id' => $mediaId,
            'external_post_url' => $permalink,
        ];
    }

    private function waitUntilReady(string $creationId, string $token): void
    {
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $status = Http::timeout(30)->get(self::BASE . "/{$creationId}", [
                'fields' => 'status,error_message',
                'access_token' => $token,
            ]);

            $state = $status->json('status');

            if ($state === 'FINISHED') {
                return;
            }

            if (in_array($state, ['ERROR', 'EXPIRED'], true)) {
                throw new RuntimeException('Threads media container failed: ' . ($status->json('error_message') ?? $state));
            }

            sleep(3);
        }
    }
}