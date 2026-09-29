<?php

namespace App\Support\Social\Drivers;

use App\Contracts\Social\SocialPublisherContract;
use App\Exceptions\Social\SkipTargetException;
use App\Models\Post;
use App\Models\RedditAllowedSubreddit;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RedditPublisher extends AbstractHttpPublisher implements SocialPublisherContract
{
    public function publish(SocialPostTarget $target, Post $post, SocialPlatformAccount $account): array
    {
        $subreddit = RedditAllowedSubreddit::approved()
            ->where('category_id', $post->category_id)
            ->first() ?? RedditAllowedSubreddit::approved()->first();

        if (!$subreddit) {
            throw new SkipTargetException('No admin-approved subreddit is configured yet.');
        }

        $response = Http::withToken($account->access_token)
            ->withHeaders(['User-Agent' => config('social.platforms.reddit.user_agent')])
            ->asForm()
            ->timeout(60)
            ->post('https://oauth.reddit.com/api/submit', [
                'sr' => $subreddit->name,
                'kind' => 'link',
                'url' => $this->postLink($post),
                'title' => $target->caption_title ?: $post->meta_title,
                'resubmit' => true,
            ]);

        $this->assertSuccessful($response, 'Reddit');

        $data = $response->json();

        if (!empty($data['json']['errors'])) {
            throw new RuntimeException('Reddit rejected the submission: ' . json_encode($data['json']['errors']));
        }

        return [
            'external_post_id' => $data['json']['data']['id'] ?? null,
            'external_post_url' => $data['json']['data']['url'] ?? null,
        ];
    }
}
