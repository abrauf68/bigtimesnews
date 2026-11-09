<?php

return [
    /*
    | Google OAuth client used to connect Search Console. Falls back to the
    | existing GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET if dedicated keys are not set.
    | The redirect URI to register in Google Cloud Console is:
    |   {APP_URL}/dashboard/google-indexing/oauth/callback
    */
    'client_id' => env('GOOGLE_INDEXING_CLIENT_ID', env('GOOGLE_CLIENT_ID')),
    'client_secret' => env('GOOGLE_INDEXING_CLIENT_SECRET', env('GOOGLE_CLIENT_SECRET')),

    // "webmasters" (read/write) is required to submit sitemaps; URL Inspection works with it too.
    'scopes' => [
        'https://www.googleapis.com/auth/webmasters',
        'openid',
        'email',
    ],

    // Google's URL Inspection API allows 2,000 queries per day per Search Console property.
    'daily_hard_cap' => 2000,
    'default_daily_limit' => 200,
    'default_batch_size' => 100,

    'log_retention_days' => 60,

    // Sitemap importing safety limits.
    'sitemap_max_depth' => 3,
    'sitemap_max_files' => 30,
    'sitemap_max_urls' => 50000,

    'user_agent' => 'BigTimesIndexingMonitor/1.0',
];
