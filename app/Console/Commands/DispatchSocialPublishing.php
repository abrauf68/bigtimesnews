<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\Social\SocialPublishingService;
use Illuminate\Console\Command;

class DispatchSocialPublishing extends Command
{
    protected $signature = 'social:dispatch {post : Post ID}';
    protected $description = 'Manually run the social-publishing dispatch for a given post (for testing).';

    public function handle(SocialPublishingService $service): int
    {
        $post = Post::find($this->argument('post'));

        if (!$post) {
            $this->error('Post not found.');
            return self::FAILURE;
        }

        if ($post->status !== 'published') {
            $this->error('Post is not published, nothing to dispatch.');
            return self::FAILURE;
        }

        $service->claimAndDispatch($post->id);

        $this->info('Dispatch attempted. Check the social_post_targets table for this post.');
        $this->table(
            ['Platform', 'Status', 'Skip reason', 'Error'],
            $post->socialTargets()->get(['platform', 'status', 'skip_reason', 'error_message'])->map(fn ($t) => [
                $t->platform, $t->status, $t->skip_reason, $t->error_message,
            ])->toArray()
        );

        return self::SUCCESS;
    }
}
