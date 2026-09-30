<?php

namespace App\Support\Social;

use App\Enums\SocialPlatform;
use App\Models\SocialPlatformAccount;

class PlatformCredentials
{
    public function clientId(SocialPlatform $platform): ?string
    {
        $value = $this->account($platform)?->client_id;

        if (empty($value) && $platform === SocialPlatform::Instagram) {
            return $this->clientId(SocialPlatform::Facebook);
        }

        return $value;
    }

    public function clientSecret(SocialPlatform $platform): ?string
    {
        $value = $this->account($platform)?->client_secret;

        if (empty($value) && $platform === SocialPlatform::Instagram) {
            return $this->clientSecret(SocialPlatform::Facebook);
        }

        return $value;
    }

    public function setting(SocialPlatform $platform, string $key, mixed $default = null): mixed
    {
        return $this->account($platform)?->settings[$key] ?? $default;
    }

    protected function account(SocialPlatform $platform): ?SocialPlatformAccount
    {
        return SocialPlatformAccount::where('platform', $platform->value)->first();
    }
}
