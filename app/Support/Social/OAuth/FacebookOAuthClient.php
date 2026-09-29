<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use RuntimeException;

class FacebookOAuthClient implements OAuthClientContract
{
    use FacebookGraphOAuthTrait;

    public function authorizeUrl(string $state): string
    {
        $params = [
            'client_id' => config('social.platforms.facebook.app_id'),
            'redirect_uri' => route('dashboard.social.callback', 'facebook'),
            'state' => $state,
            'scope' => 'pages_show_list,pages_manage_posts,pages_read_engagement,business_management',
        ];

        return 'https://www.facebook.com/v19.0/dialog/oauth?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $userToken = $this->exchangeUserToken($code, 'facebook');
        $page = $this->findPage($userToken);

        if (!$page) {
            throw new RuntimeException('No Facebook Page was found for this account. Make sure the person connecting manages at least one Page.');
        }

        return [
            'access_token' => $page['access_token'],
            'refresh_token' => null,
            'expires_in' => null,
            'external_account_id' => $page['id'],
            'display_name' => $page['name'] ?? null,
            'meta' => ['page_id' => $page['id']],
        ];
    }

    public function refresh(string $refreshToken): array
    {
        throw new RuntimeException('Facebook Page tokens do not use refresh tokens. Reconnect from the admin panel if the token expires.');
    }
}
