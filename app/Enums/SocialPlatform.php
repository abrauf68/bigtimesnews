<?php

namespace App\Enums;

enum SocialPlatform: string
{
    case X = 'x';
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Threads = 'threads';
    case LinkedIn = 'linkedin';
    case Pinterest = 'pinterest';
    case Tumblr = 'tumblr';
    case Reddit = 'reddit';

    public function label(): string
    {
        return match ($this) {
            self::X => 'X (Twitter)',
            self::Facebook => 'Facebook',
            self::Instagram => 'Instagram',
            self::Threads => 'Threads',
            self::LinkedIn => 'LinkedIn',
            self::Pinterest => 'Pinterest',
            self::Tumblr => 'Tumblr',
            self::Reddit => 'Reddit',
        };
    }

    public function config(): array
    {
        return config('social.platforms.' . $this->value, []);
    }

    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}
