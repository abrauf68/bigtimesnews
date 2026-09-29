<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PinterestOAuthClient implements OAuthClientContract
{
    public function authorizeUrl(string $state): string
    {
        $params = [
            'response_type' => 'code',
            'client_id' => config('social.platforms.pinterest.client_id'),
            'redirect_uri' => route('dashboard.social.callback', 'pinterest'),
            'state' => $state,
            'scope' => 'boards:read,pins:write,pins:read',
        ];

        return 'https://www.pinterest.com/oauth/?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $response = Http::asForm()
            ->withBasicAuth(config('social.platforms.pinterest.client_id'), config('social.platforms.pinterest.client_secret'))
            ->post('https://api.pinterest.com/v5/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('dashboard.social.callback', 'pinterest'),
            ]);

        return $this->mapToken($response);
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::asForm()
            ->withBasicAuth(config('social.platforms.pinterest.client_id'), config('social.platforms.pinterest.client_secret'))
            ->post('https://api.pinterest.com/v5/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

        return $this->mapToken($response);
    }

    private function mapToken(Response $response): array
    {
        if (!$response->successful()) {
            throw new RuntimeException('Pinterest token request failed: ' . $response->body());
        }

        $data = $response->json();

        return [
            'access_token' => $data['access_token'] ?? null,
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_in' => $data['expires_in'] ?? null,
            'external_account_id' => null,
            'display_name' => null,
            'meta' => [],
        ];
    }
}
