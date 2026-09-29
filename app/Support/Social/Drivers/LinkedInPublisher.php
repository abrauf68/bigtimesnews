<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class LinkedInPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $owner = $account->meta['organization_urn'] ?? config('social.platforms.linkedin.organization_urn');

        $register = Http::withToken($account->access_token)
            ->withHeaders(['X-Restli-Protocol-Version' => '2.0.0'])
            ->timeout(60)
            ->post('https://api.linkedin.com/v2/assets?action=registerUpload', [
                'registerUploadRequest' => [
                    'recipes' => ['urn:li:digitalmediaRecipe:feedshare-image'],
                    'owner' => $owner,
                    'serviceRelationships' => [
                        ['relationshipType' => 'OWNER', 'identifier' => 'urn:li:userGeneratedContent'],
                    ],
                ],
            ]);
        $this->assertSuccessful($register, 'LinkedIn');

        $data = $register->json();
        $uploadUrl = $data['value']['uploadMechanism']['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']['uploadUrl'] ?? null;
        $asset = $data['value']['asset'] ?? null;

        if (!$uploadUrl || !$asset) {
            throw new RuntimeException('LinkedIn did not return an upload URL for the image asset.');
        }

        $imageBytes = Http::timeout(30)->get($this->imageUrl($post))->body();
        Http::withToken($account->access_token)->withBody($imageBytes, 'image/jpeg')->timeout(60)->put($uploadUrl);

        $ugcResponse = Http::withToken($account->access_token)
            ->withHeaders(['X-Restli-Protocol-Version' => '2.0.0'])
            ->timeout(60)
            ->post('https://api.linkedin.com/v2/ugcPosts', [
                'author' => $owner,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => ['text' => $target->caption],
                        'shareMediaCategory' => 'IMAGE',
                        'media' => [
                            ['status' => 'READY', 'media' => $asset],
                        ],
                    ],
                ],
                'visibility' => ['com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'],
            ]);
        $this->assertSuccessful($ugcResponse, 'LinkedIn');

        $postId = $ugcResponse->header('x-restli-id') ?: $ugcResponse->json('id');

        return ['external_post_id' => $postId, 'external_post_url' => null];
    }
}
