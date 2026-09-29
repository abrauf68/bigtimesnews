<?php

namespace App\Support\Social;

use App\Contracts\Social\SocialPublisherContract;
use App\Enums\SocialPlatform;
use App\Exceptions\Social\SkipTargetException;

class SocialPublisherManager
{
    public function driverFor(SocialPlatform $platform): SocialPublisherContract
    {
        $class = config('social.drivers.' . $platform->value);

        if (empty($class) || !class_exists($class)) {
            throw new SkipTargetException(
                $platform->label() . ' publishing is not available yet.'
            );
        }

        return app($class);
    }
}
