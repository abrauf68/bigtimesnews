<?php

namespace App\Console\Commands;

use App\Mail\SocialAccountUnhealthyMail;
use App\Models\AiBlogSetting;
use App\Models\SocialPlatformAccount;
use App\Support\Social\OAuthClientManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class RefreshSocialTokens extends Command
{
    protected $signature = 'social:refresh-tokens';
    protected $description = 'Refresh social platform access tokens that are expiring soon, and mark accounts unhealthy if refresh fails.';

    public function handle(OAuthClientManager $manager): int
    {
        $accounts = SocialPlatformAccount::where('status', 'connected')
            ->whereNotNull('refresh_token')
            ->whereNotNull('token_expires_at')
            ->where('token_expires_at', '<=', now()->addHours(24))
            ->get();

        foreach ($accounts as $account) {
            try {
                $result = $manager->forPlatform($account->platformEnum())->refresh($account->refresh_token);

                $account->update([
                    'access_token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'] ?? $account->refresh_token,
                    'token_expires_at' => !empty($result['expires_in']) ? now()->addSeconds((int) $result['expires_in']) : $account->token_expires_at,
                    'health' => 'healthy',
                    'health_message' => null,
                    'last_checked_at' => now(),
                ]);

                $this->info($account->platformEnum()->label() . ' token refreshed.');
            } catch (Throwable $e) {
                Log::error('Social token refresh failed', [
                    'platform' => $account->platform,
                    'error' => $e->getMessage(),
                ]);

                $account->update([
                    'health' => 'unhealthy',
                    'health_message' => 'Automatic token refresh failed: ' . $e->getMessage(),
                    'last_checked_at' => now(),
                ]);

                $this->notifyAdmin($account);
                $this->error($account->platformEnum()->label() . ' token refresh failed: ' . $e->getMessage());
            }
        }

        return self::SUCCESS;
    }

    protected function notifyAdmin(SocialPlatformAccount $account): void
    {
        if ($account->last_health_notified_at !== null && $account->last_health_notified_at->greaterThan(now()->subHours(6))) {
            return;
        }

        $adminEmail = AiBlogSetting::first()?->admin_email ?? config('mail.from.address');

        if (empty($adminEmail)) {
            return;
        }

        try {
            Mail::to($adminEmail)->send(new SocialAccountUnhealthyMail($account));
            $account->update(['last_health_notified_at' => now()]);
        } catch (Throwable $e) {
            Log::error('Failed to send social token refresh notification', [
                'account_id' => $account->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
