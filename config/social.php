<?php

return [

    'connect_redirect_base' => env('SOCIAL_CONNECT_REDIRECT_BASE', env('APP_URL')),

    'drivers' => [
        'x' => \App\Support\Social\Drivers\XPublisher::class,
        'facebook' => \App\Support\Social\Drivers\FacebookPublisher::class,
        'instagram' => \App\Support\Social\Drivers\InstagramPublisher::class,
        'linkedin' => \App\Support\Social\Drivers\LinkedInPublisher::class,
        'pinterest' => \App\Support\Social\Drivers\PinterestPublisher::class,
        'tumblr' => \App\Support\Social\Drivers\TumblrPublisher::class,
        'reddit' => \App\Support\Social\Drivers\RedditPublisher::class,
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
            'client_id' => env('X_CLIENT_ID'),
            'client_secret' => env('X_CLIENT_SECRET'),
            'api_key' => env('X_API_KEY'),
            'api_secret' => env('X_API_SECRET'),
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
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'page_id' => env('FACEBOOK_PAGE_ID'),
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
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'ig_business_account_id' => env('INSTAGRAM_BUSINESS_ACCOUNT_ID'),
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
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'organization_urn' => env('LINKEDIN_ORGANIZATION_URN'),
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
            'client_id' => env('PINTEREST_CLIENT_ID'),
            'client_secret' => env('PINTEREST_CLIENT_SECRET'),
            'board_id' => env('PINTEREST_BOARD_ID'),
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
            'client_id' => env('TUMBLR_CLIENT_ID'),
            'client_secret' => env('TUMBLR_CLIENT_SECRET'),
            'blog_identifier' => env('TUMBLR_BLOG_IDENTIFIER'),
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
            'client_id' => env('REDDIT_CLIENT_ID'),
            'client_secret' => env('REDDIT_CLIENT_SECRET'),
            'username' => env('REDDIT_USERNAME'),
            'user_agent' => env('REDDIT_USER_AGENT', 'bigtimesnews-publisher/1.0'),
        ],

    ],

];
