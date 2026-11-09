<?php

namespace App\Services\GoogleIndexing;

use App\Exceptions\GoogleIndexing\GoogleApiException;
use App\Exceptions\GoogleIndexing\GoogleAuthException;
use App\Models\IndexingLog;
use App\Models\IndexingSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleOAuthService
{
    public const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    public const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    public const USERINFO_URL = 'https://openidconnect.googleapis.com/v1/userinfo';

    public function isConfigured(): bool
    {
        return filled(config('google_indexing.client_id')) && filled(config('google_indexing.client_secret'));
    }

    public function redirectUri(): string
    {
        return route('dashboard.google_indexing.oauth.callback');
    }

    public function authorizeUrl(IndexingSite $site, string $state): string
    {
        return self::AUTH_URL . '?' . http_build_query([
            'client_id' => config('google_indexing.client_id'),
            'redirect_uri' => $this->redirectUri(),
            'response_type' => 'code',
            'scope' => implode(' ', config('google_indexing.scopes')),
            'access_type' => 'offline',       // get a refresh token
            'prompt' => 'consent',            // always return the refresh token
            'include_granted_scopes' => 'true',
            'state' => $state,
        ]);
    }

    /** Exchange the authorization code and store encrypted tokens on the site. */
    public function connect(IndexingSite $site, string $code): void
    {
        $response = Http::asForm()->timeout(30)->post(self::TOKEN_URL, [
            'code' => $code,
            'client_id' => config('google_indexing.client_id'),
            'client_secret' => config('google_indexing.client_secret'),
            'redirect_uri' => $this->redirectUri(),
            'grant_type' => 'authorization_code',
        ]);

        if (!$response->successful()) {
            throw new GoogleApiException('Google token exchange failed: ' . $this->errorText($response->json(), $response->body()), $response->status());
        }

        $data = $response->json();
        $refresh = $data['refresh_token'] ?? $site->refresh_token;

        if (empty($refresh)) {
            throw new GoogleApiException('Google did not return a refresh token. Remove the app from your Google account permissions and connect again.');
        }

        $email = null;
        try {
            $info = Http::withToken($data['access_token'])->timeout(15)->get(self::USERINFO_URL);
            $email = $info->json('email');
        } catch (\Throwable $e) {
            // Email is only informational.
        }

        $site->update([
            'access_token' => $data['access_token'],
            'refresh_token' => $refresh,
            'token_expires_at' => now()->addSeconds((int) ($data['expires_in'] ?? 3600)),
            'google_email' => $email ?: $site->google_email,
            'status' => 'connected',
            'health' => 'healthy',
            'health_message' => null,
        ]);

        IndexingLog::record($site->id, 'oauth', 'info', 'Google Search Console connected' . ($email ? " as {$email}" : '') . '.');
    }

    public function disconnect(IndexingSite $site): void
    {
        // Best effort revoke so the grant disappears from the Google account too.
        $token = $site->refresh_token ?: $site->access_token;
        if ($token) {
            try {
                Http::asForm()->timeout(15)->post('https://oauth2.googleapis.com/revoke', ['token' => $token]);
            } catch (\Throwable $e) {
            }
        }

        $site->update([
            'access_token' => null,
            'refresh_token' => null,
            'token_expires_at' => null,
            'status' => 'disconnected',
        ]);

        IndexingLog::record($site->id, 'oauth', 'info', 'Google Search Console disconnected.');
    }

    /** Returns a valid access token, refreshing it when it expires within two minutes. */
    public function validAccessToken(IndexingSite $site, bool $forceRefresh = false): string
    {
        if (!$site->isConnected()) {
            throw new GoogleAuthException('Site is not connected to Google Search Console.');
        }

        if (!$forceRefresh && $site->access_token && $site->token_expires_at && $site->token_expires_at->gt(now()->addMinutes(2))) {
            return $site->access_token;
        }

        // One refresh at a time per site, so parallel jobs don't race.
        return Cache::lock("gi-refresh-{$site->id}", 20)->block(15, function () use ($site, $forceRefresh) {
            $site->refresh();

            if (!$forceRefresh && $site->access_token && $site->token_expires_at && $site->token_expires_at->gt(now()->addMinutes(2))) {
                return $site->access_token;
            }

            return $this->refreshToken($site);
        });
    }

    protected function refreshToken(IndexingSite $site): string
    {
        $response = Http::asForm()->timeout(30)->post(self::TOKEN_URL, [
            'client_id' => config('google_indexing.client_id'),
            'client_secret' => config('google_indexing.client_secret'),
            'refresh_token' => $site->refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if (!$response->successful()) {
            $error = $response->json('error');
            $text = $this->errorText($response->json(), $response->body());

            // invalid_grant = revoked or expired refresh token: the admin must reconnect.
            if ($error === 'invalid_grant' || $response->status() === 400 || $response->status() === 401) {
                $site->update(['status' => 'disconnected', 'health' => 'unhealthy', 'health_message' => 'Google access was revoked or expired. Please reconnect.']);
                IndexingLog::record($site->id, 'oauth', 'error', 'Token refresh failed, reconnect required: ' . $text);
                throw new GoogleAuthException('Google access was revoked or expired. Please reconnect.', $response->status());
            }

            throw new GoogleApiException('Token refresh failed: ' . $text, $response->status());
        }

        $data = $response->json();
        $site->update([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? $site->refresh_token,
            'token_expires_at' => now()->addSeconds((int) ($data['expires_in'] ?? 3600)),
        ]);

        return $data['access_token'];
    }

    protected function errorText(mixed $json, string $fallback): string
    {
        if (is_array($json)) {
            return trim(($json['error'] ?? '') . ' ' . ($json['error_description'] ?? '')) ?: mb_substr($fallback, 0, 200);
        }

        return mb_substr($fallback, 0, 200);
    }
}
