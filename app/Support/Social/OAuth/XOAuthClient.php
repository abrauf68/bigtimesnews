<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use App\Enums\SocialPlatform;
use App\Support\Social\PlatformCredentials;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class XOAuthClient implements OAuthClientContract
{
    public function __construct(protected PlatformCredentials $credentials)
    {
    }

    public function authorizeUrl(string $state): string
    {
        $verifier = Str::random(64);
        session(['social_x_code_verifier' => $verifier]);
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        $params = [
            'response_type' => 'code',
            'client_id' => $this->credentials->clientId(SocialPlatform::X),
            'redirect_uri' => route('social.callback', 'x'),
            'scope' => 'tweet.read tweet.write users.read offline.access',
            'state' => $state,
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ];

        return 'https://x.com/i/oauth2/authorize?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $verifier = session('social_x_code_verifier');

        $response = Http::asForm()
            ->withBasicAuth($this->credentials->clientId(SocialPlatform::X), $this->credentials->clientSecret(SocialPlatform::X))
            ->post('https://api.x.com/2/oauth2/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => route('social.callback', 'x'),
                'code_verifier' => $verifier,
            ]);

        return $this->mapToken($response);
    }

    public function refresh(string $refreshToken): array
    {
        $response = Http::asForm()
            ->withBasicAuth($this->credentials->clientId(SocialPlatform::X), $this->credentials->clientSecret(SocialPlatform::X))
            ->post('https://api.x.com/2/oauth2/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

        return $this->mapToken($response);
    }

    private function mapToken(Response $response): array
    {
        if (!$response->successful()) {
            throw new RuntimeException('X token request failed: ' . $response->body());
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
