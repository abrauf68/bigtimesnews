<?php

return [

    'drivers' => [
        'x' => \App\Support\Social\Drivers\XPublisher::class,
        'facebook' => \App\Support\Social\Drivers\FacebookPublisher::class,
        'instagram' => \App\Support\Social\Drivers\InstagramPublisher::class,
        'linkedin' => \App\Support\Social\Drivers\LinkedInPublisher::class,
        'pinterest' => \App\Support\Social\Drivers\PinterestPublisher::class,
        'tumblr' => \App\Support\Social\Drivers\TumblrPublisher::class,
        'reddit' => \App\Support\Social\Drivers\RedditPublisher::class,
    ],

    'credential_fields' => [
        'x' => [],
        'facebook' => [
            'page_id' => 'Facebook Page ID (optional — leave blank to auto-select the first Page you manage)',
        ],
        'instagram' => [],
        'linkedin' => [
            'organization_urn' => 'Organization URN (e.g. urn:li:organization:12345678)',
        ],
        'pinterest' => [
            'board_id' => 'Board ID to pin to',
        ],
        'tumblr' => [
            'blog_identifier' => 'Blog identifier (e.g. yourblog.tumblr.com)',
        ],
        'reddit' => [
            'username' => 'Reddit bot account username',
            'user_agent' => 'User agent string (e.g. yourapp-publisher/1.0 by yourusername)',
        ],
    ],

    'platforms' => [

        'x' => [
            'caption_limit' => 250,
            'supports_image' => true,
            'image' => [
                'max_mb' => 5,
                'formats' => ['jpg', 'jpeg', 'png', 'webp'],
                'min_width' => 200,
                'min_height' => 200,
            ],
        ],

        'facebook' => [
            'caption_limit' => 5000,
            'supports_image' => true,
            'image' => [
                'max_mb' => 8,
                'formats' => ['jpg', 'jpeg', 'png'],
                'min_width' => 200,
                'min_height' => 200,
            ],
        ],

        'instagram' => [
            'caption_limit' => 2200,
            'supports_image' => true,
            'requires_hashtags' => true,
            'requires_link_in_bio_note' => true,
            'image' => [
                'max_mb' => 8,
                'formats' => ['jpg', 'jpeg', 'png'],
                'min_width' => 320,
                'min_height' => 320,
                'min_aspect_ratio' => 0.8,
                'max_aspect_ratio' => 1.91,
            ],
        ],

        'linkedin' => [
            'caption_limit' => 3000,
            'supports_image' => true,
            'image' => [
                'max_mb' => 10,
                'formats' => ['jpg', 'jpeg', 'png'],
                'min_width' => 200,
                'min_height' => 200,
            ],
        ],

        'pinterest' => [
            'caption_limit' => 500,
            'title_limit' => 100,
            'supports_image' => true,
            'requires_title_and_description' => true,
            'image' => [
                'max_mb' => 20,
                'formats' => ['jpg', 'jpeg', 'png'],
                'min_width' => 200,
                'min_height' => 300,
                'min_aspect_ratio' => 0.5,
                'max_aspect_ratio' => 1.0,
            ],
        ],

        'tumblr' => [
            'caption_limit' => 4096,
            'supports_image' => true,
            'image' => [
                'max_mb' => 10,
                'formats' => ['jpg', 'jpeg', 'png', 'gif'],
                'min_width' => 200,
                'min_height' => 200,
            ],
        ],

        'reddit' => [
            'caption_limit' => 300,
            'title_limit' => 300,
            'supports_image' => true,
            'requires_neutral_title' => true,
            'requires_subreddit_approval' => true,
            'image' => [
                'max_mb' => 20,
                'formats' => ['jpg', 'jpeg', 'png'],
                'min_width' => 200,
                'min_height' => 200,
            ],
        ],

    ],

];
