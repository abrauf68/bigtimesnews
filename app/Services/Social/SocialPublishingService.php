<?php

namespace App\Services\Social;

use App\Contracts\Social\CaptionGeneratorContract;
use App\Enums\SocialPlatform;
use App\Exceptions\Social\InvalidTokenSocialException;
use App\Exceptions\Social\SkipTargetException;
use App\Jobs\Social\PublishToPlatformJob;
use App\Models\Post;
use App\Models\RedditAllowedSubreddit;
use App\Models\SocialPlatformAccount;
use App\Models\SocialPostTarget;
use App\Mail\SocialAccountUnhealthyMail;
use App\Models\AiBlogSetting;
use App\Support\Social\ImageSuitabilityChecker;
use App\Support\Social\SocialPublisherManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SocialPublishingService
{
    public function __construct(
        protected CaptionGeneratorContract $captionGenerator,
        protected SocialPublisherManager $publisherManager,
        protected ImageSuitabilityChecker $imageChecker,
    ) {
    }

    public function claimAndDispatch(int $postId): void
    {
        $claimed = DB::table('posts')
            ->where('id', $postId)
            ->whereNull('social_dispatched_at')
            ->update(['social_dispatched_at' => now()]);

        if ($claimed !== 1) {
            return;
        }

        $post = Post::find($postId);

        if (!$post || $post->status !== 'published') {
            return;
        }

        foreach (SocialPlatform::cases() as $platform) {
            $target = SocialPostTarget::firstOrCreate(
                ['post_id' => $post->id, 'platform' => $platform->value],
                ['is_enabled' => true, 'status' => 'pending']
            );

            if ($target->status === 'posted') {
                continue;
            }

            PublishToPlatformJob::dispatch($target->id);
        }
    }

    public function retryTarget(SocialPostTarget $target): void
    {
        if ($target->status === 'posted') {
            return;
        }

        $target->update([
            'status' => 'pending',
            'error_message' => null,
            'skip_reason' => null,
        ]);

        PublishToPlatformJob::dispatch($target->id);
    }

    public function publishTarget(SocialPostTarget $target, int $attemptNumber = 1): void
    {
        $target->refresh();

        if ($target->status === 'posted') {
            return;
        }

        if (!$target->is_enabled) {
            $target->update(['status' => 'skipped', 'skip_reason' => 'Disabled for this post.']);
            return;
        }

        $post = $target->post;

        if (!$post) {
            $target->update(['status' => 'failed', 'error_message' => 'Post no longer exists.']);
            return;
        }

        $platform = $target->platformEnum();

        $account = SocialPlatformAccount::where('platform', $platform->value)->first();

        if (!$account || !$account->isConnected()) {
            $target->update(['status' => 'skipped', 'skip_reason' => $platform->label() . ' account is not connected.']);
            return;
        }

        if (!$account->is_enabled) {
            $target->update(['status' => 'skipped', 'skip_reason' => $platform->label() . ' is disabled by the admin.']);
            return;
        }

        if (!$account->isHealthy()) {
            $target->update(['status' => 'skipped', 'skip_reason' => $platform->label() . ' account is unhealthy. Reconnect it from the admin panel.']);
            return;
        }

        if ($platform === SocialPlatform::Reddit && !RedditAllowedSubreddit::approved()->exists()) {
            $target->update(['status' => 'skipped', 'skip_reason' => 'No admin-approved subreddit is configured yet.']);
            return;
        }

        $imageIssue = $this->imageChecker->check($post, $platform);
        if ($imageIssue !== null) {
            $target->update(['status' => 'skipped', 'skip_reason' => $imageIssue]);
            return;
        }

        if (empty($target->caption)) {
            $generated = $this->captionGenerator->generate($post, $platform);
            $target->update([
                'caption' => $generated['caption'],
                'caption_title' => $generated['title'] ?? null,
                'caption_source' => $generated['source'],
            ]);
            $target->refresh();
        }

        $target->update([
            'status' => 'queued',
            'attempts' => $attemptNumber,
            'last_attempted_at' => now(),
        ]);

        try {
            $result = $this->publisherManager->driverFor($platform)->publish($target, $post, $account);

            $target->update([
                'status' => 'posted',
                'external_post_id' => $result['external_post_id'] ?? null,
                'external_post_url' => $result['external_post_url'] ?? null,
                'posted_at' => now(),
                'error_message' => null,
            ]);
        } catch (SkipTargetException $e) {
            $target->update(['status' => 'skipped', 'skip_reason' => $e->getMessage()]);
        } catch (InvalidTokenSocialException $e) {
            $account->update([
                'health' => 'unhealthy',
                'health_message' => $e->getMessage(),
            ]);
            $target->update(['status' => 'failed', 'error_message' => $e->getMessage()]);
            $this->notifyAdminOfUnhealthyAccount($account);
        } catch (Throwable $e) {
            $target->update(['error_message' => $e->getMessage()]);
            Log::error('Social publish attempt failed', [
                'target_id' => $target->id,
                'platform' => $platform->value,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    protected function notifyAdminOfUnhealthyAccount(SocialPlatformAccount $account): void
    {
        $account->refresh();

        if ($account->last_health_notified_at !== null && $account->last_health_notified_at->greaterThan(now()->subHours(6))) {
            return;
        }

        $adminEmail = AiBlogSetting::first()->admin_email ?? config('mail.from.address');

        if (empty($adminEmail)) {
            return;
        }

        try {
            Mail::to($adminEmail)->send(new SocialAccountUnhealthyMail($account));
            $account->update(['last_health_notified_at' => now()]);
        } catch (Throwable $e) {
            Log::error('Failed to send social account unhealthy notification', [
                'account_id' => $account->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
