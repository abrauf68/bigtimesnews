<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Models\Post;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;

class TumblrPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $blog = $account->meta['blog_identifier'] ?? config('social.platforms.tumblr.blog_identifier');
        $tags = is_array($post->tags) ? $post->tags : (json_decode((string) $post->tags, true) ?: []);

        $response = Http::withToken($account->access_token)->timeout(60)->post("https://api.tumblr.com/v2/blog/{$blog}/posts", [
            'content' => [
                ['type' => 'image', 'media' => [['url' => $this->imageUrl($post)]]],
                ['type' => 'text', 'text' => $target->caption],
            ],
            'tags' => implode(',', $tags),
        ]);
        $this->assertSuccessful($response, 'Tumblr');
        $id = $response->json('response.id') ?? $response->json('id');

        return [
            'external_post_id' => $id,
            'external_post_url' => $id ? "https://{$blog}/post/{$id}" : null,
        ];
    }
}
