<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class LinkedInOAuthClient implements OAuthClientContract
{
    public function authorizeUrl(string $state): string
    {
        $params = [
            'response_type' => 'code',
            'client_id' => config('social.platforms.linkedin.client_id'),
            'redirect_uri' => route('dashboard.social.callback', 'linkedin'),
            'state' => $state,
            'scope' => 'w_member_social w_organization_social r_organization_social',
        ];

        return 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => route('dashboard.social.callback', 'linkedin'),
            'client_id' => config('social.platforms.linkedin.client_id'),
            'client_secret' => config('social.platforms.linkedin.client_secret'),
        ]);

        return $this->mapToken($response);
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('social.platforms.linkedin.client_id'),
            'client_secret' => config('social.platforms.linkedin.client_secret'),
        ]);

        return $this->mapToken($response);
    }

    private function mapToken(Response $response): array
    {
        if (!$response->successful()) {
            throw new RuntimeException('LinkedIn token request failed: ' . $response->body());
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
