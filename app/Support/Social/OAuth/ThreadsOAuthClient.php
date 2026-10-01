<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use App\Enums\SocialPlatform;
use App\Support\Social\PlatformCredentials;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ThreadsOAuthClient implements OAuthClientContract
{
    public function __construct(protected PlatformCredentials $credentials)
    {
    }

    public function authorizeUrl(string $state): string
    {
        $params = [
            'client_id' => $this->credentials->clientId(SocialPlatform::Threads),
            'redirect_uri' => route('social.callback', 'threads'),
            'scope' => 'threads_basic,threads_content_publish',
            'response_type' => 'code',
            'state' => $state,
        ];

        return 'https://threads.net/oauth/authorize?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $short = Http::asForm()->post('https://graph.threads.net/oauth/access_token', [
            'client_id' => $this->credentials->clientId(SocialPlatform::Threads),
            'client_secret' => $this->credentials->clientSecret(SocialPlatform::Threads),
            'grant_type' => 'authorization_code',
            'redirect_uri' => route('social.callback', 'threads'),
            'code' => $code,
        ]);

        if (!$short->successful()) {
            throw new RuntimeException('Threads token exchange failed: ' . $short->body());
        }

        $long = Http::get('https://graph.threads.net/access_token', [
            'grant_type' => 'th_exchange_token',
            'client_secret' => $this->credentials->clientSecret(SocialPlatform::Threads),
            'access_token' => $short->json('access_token'),
        ]);

        if (!$long->successful()) {
            throw new RuntimeException('Threads long-lived token exchange failed: ' . $long->body());
        }

        $token = $long->json('access_token');

        $profile = Http::get('https://graph.threads.net/v1.0/me', [
            'fields' => 'id,username',
            'access_token' => $token,
        ]);

        $userId = (string) ($profile->json('id') ?? $short->json('user_id'));

        return [
            'access_token' => $token,
            'refresh_token' => $token,
            'expires_in' => $long->json('expires_in'),
            'external_account_id' => $userId,
            'display_name' => $profile->json('username'),
            'meta' => ['threads_user_id' => $userId],
        ];
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::get('https://graph.threads.net/refresh_access_token', [
            'grant_type' => 'th_refresh_token',
            'access_token' => $refreshToken,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Threads token refresh failed: ' . $response->body());
        }

        $token = $response->json('access_token');

        return [
            'access_token' => $token,
            'refresh_token' => $token,
            'expires_in' => $response->json('expires_in'),
            'external_account_id' => null,
            'display_name' => null,
            'meta' => [],
        ];
    }
}