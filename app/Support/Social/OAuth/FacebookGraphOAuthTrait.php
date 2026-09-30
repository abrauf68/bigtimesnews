<?php

namespace App\Support\Social\OAuth;

use App\Enums\SocialPlatform;
use Illuminate\Support\Facades\Http;
use RuntimeException;

trait FacebookGraphOAuthTrait
{
    protected function exchangeUserToken(string $code, string $platformSlug): string
    {
        $response = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'client_id' => $this->credentials->clientId(SocialPlatform::Facebook),
            'client_secret' => $this->credentials->clientSecret(SocialPlatform::Facebook),
            'redirect_uri' => route('social.callback', $platformSlug),
            'code' => $code,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Facebook token exchange failed: ' . $response->body());
        }

        $shortToken = $response->json('access_token');

        $long = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'grant_type' => 'fb_exchange_token',
            'client_id' => $this->credentials->clientId(SocialPlatform::Facebook),
            'client_secret' => $this->credentials->clientSecret(SocialPlatform::Facebook),
            'fb_exchange_token' => $shortToken,
        ]);

        return $long->successful() ? $long->json('access_token') : $shortToken;
    }

    protected function findPage(string $userToken): ?array
    {
        $configuredPageId = $this->credentials->setting(SocialPlatform::Facebook, 'page_id');

        $pages = Http::get('https://graph.facebook.com/v19.0/me/accounts', [
            'access_token' => $userToken,
        ])->json('data', []);

        foreach ($pages as $page) {
            if (!$configuredPageId || $page['id'] === $configuredPageId) {
                return $page;
            }
        }

        return $pages[0] ?? null;
    }
}
