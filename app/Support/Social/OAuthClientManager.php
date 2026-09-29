<?php

namespace App\Support\Social;

use App\Contracts\Social\OAuthClientContract;
use App\Enums\SocialPlatform;
use App\Support\Social\OAuth\FacebookOAuthClient;
use App\Support\Social\OAuth\InstagramOAuthClient;
use App\Support\Social\OAuth\LinkedInOAuthClient;
use App\Support\Social\OAuth\PinterestOAuthClient;
use App\Support\Social\OAuth\RedditOAuthClient;
use App\Support\Social\OAuth\TumblrOAuthClient;
use App\Support\Social\OAuth\XOAuthClient;

class OAuthClientManager
{
    public function forPlatform(SocialPlatform $platform): OAuthClientContract
    {
        return match ($platform) {
            SocialPlatform::X => app(XOAuthClient::class),
            SocialPlatform::Facebook => app(FacebookOAuthClient::class),
            SocialPlatform::Instagram => app(InstagramOAuthClient::class),
            SocialPlatform::LinkedIn => app(LinkedInOAuthClient::class),
            SocialPlatform::Pinterest => app(PinterestOAuthClient::class),
            SocialPlatform::Tumblr => app(TumblrOAuthClient::class),
            SocialPlatform::Reddit => app(RedditOAuthClient::class),
        };
    }
}
