<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RedditOAuthClient implements OAuthClientContract
{
    public function authorizeUrl(string $state): string
    {
        $params = [
            'response_type' => 'code',
            'client_id' => config('social.platforms.reddit.client_id'),
            'redirect_uri' => route('dashboard.social.callback', 'reddit'),
            'state' => $state,
            'scope' => 'submit identity',
            'duration' => 'permanent',
        ];

        return 'https://www.reddit.com/api/v1/authorize?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $response = Http::asForm()
            ->withBasicAuth(config('social.platforms.reddit.client_id'), config('social.platforms.reddit.client_secret'))
            ->withHeaders(['User-Agent' => config('social.platforms.reddit.user_agent')])
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('dashboard.social.callback', 'reddit'),
            ]);

        return $this->mapToken($response);
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::asForm()
            ->withBasicAuth(config('social.platforms.reddit.client_id'), config('social.platforms.reddit.client_secret'))
            ->withHeaders(['User-Agent' => config('social.platforms.reddit.user_agent')])
            ->post('https://www.reddit.com/api/v1/access_token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

        return $this->mapToken($response);
    }

    private function mapToken(Response $response): array
    {
        if (!$response->successful()) {
            throw new RuntimeException('Reddit token request failed: ' . $response->body());
        }

        $data = $response->json();

        return [
            'access_token' => $data['access_token'] ?? null,
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_in' => $data['expires_in'] ?? null,
            'external_account_id' => null,
            'display_name' => config('social.platforms.reddit.username'),
            'meta' => [],
        ];
    }
}
