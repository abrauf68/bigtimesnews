<?php

namespace App\Support\Social\OAuth;

use App\Contracts\Social\OAuthClientContract;
use App\Support\Social\PlatformCredentials;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class InstagramOAuthClient implements OAuthClientContract
{
    use FacebookGraphOAuthTrait;

    public function __construct(protected PlatformCredentials $credentials)
    {
    }

    public function authorizeUrl(string $state): string
    {
        $params = [
            'client_id' => $this->credentials->clientId(\App\Enums\SocialPlatform::Facebook),
            'redirect_uri' => route('social.callback', 'instagram'),
            'state' => $state,
            'scope' => 'pages_show_list,instagram_basic,instagram_content_publish,business_management',
        ];

        return 'https://www.facebook.com/v19.0/dialog/oauth?' . http_build_query($params);
    }

    public function exchangeCode(string $code): array
    {
        $userToken = $this->exchangeUserToken($code, 'instagram');
        $page = $this->findPage($userToken);

        if (!$page) {
            throw new RuntimeException('No Facebook Page linked to an Instagram Business account was found.');
        }

        $igAccount = Http::get("https://graph.facebook.com/v19.0/{$page['id']}", [
            'fields' => 'instagram_business_account',
            'access_token' => $page['access_token'],
        ])->json('instagram_business_account.id');

        if (!$igAccount) {
            throw new RuntimeException('The selected Facebook Page has no linked Instagram Business account.');
        }

        return [
            'access_token' => $page['access_token'],
            'refresh_token' => null,
            'expires_in' => null,
            'external_account_id' => $igAccount,
            'display_name' => $page['name'] ?? null,
            'meta' => ['ig_business_account_id' => $igAccount, 'page_id' => $page['id']],
        ];
    }

    public function refresh(string $refreshToken): array
    {
        throw new RuntimeException('Instagram tokens inherit from the linked Facebook Page. Reconnect from the admin panel if needed.');
    }
}
