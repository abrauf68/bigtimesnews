<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TumblrOAuthClient implements OAuthClientContract
{
    public function authorizeUrl(string $state): string
    {
        $params = [
            'response_type' => 'code',
            'client_id' => config('social.platforms.tumblr.client_id'),
            'redirect_uri' => route('dashboard.social.callback', 'tumblr'),
            'state' => $state,
            'scope' => 'write offline_access',
        ];

        return 'https://www.tumblr.com/oauth2/authorize?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $response = Http::asForm()->post('https://api.tumblr.com/v2/oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => route('dashboard.social.callback', 'tumblr'),
            'client_id' => config('social.platforms.tumblr.client_id'),
            'client_secret' => config('social.platforms.tumblr.client_secret'),
        ]);

        return $this->mapToken($response);
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::asForm()->post('https://api.tumblr.com/v2/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('social.platforms.tumblr.client_id'),
            'client_secret' => config('social.platforms.tumblr.client_secret'),
        ]);

        return $this->mapToken($response);
    }

    private function mapToken(Response $response): array
    {
        if (!$response->successful()) {
            throw new RuntimeException('Tumblr token request failed: ' . $response->body());
        }

        $data = $response->json();

        return [
            'access_token' => $data['access_token'] ?? null,
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_in' => $data['expires_in'] ?? null,
            'external_account_id' => null,
            'display_name' => config('social.platforms.tumblr.blog_identifier'),
            'meta' => [],
        ];
    }
}
