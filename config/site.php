<?php

/*
|--------------------------------------------------------------------------
| Site identity used by About / Contact / Privacy / Terms pages
|--------------------------------------------------------------------------
| Sab values .env se override ho sakti hain. Live karne se pehle
| contact email, address aur social links apne asli details se set karein.
*/

return [
    // IndexNow key (8-128 chars, letters/numbers/dash). .env mein INDEXNOW_KEY set karein.
    'indexnow_key' => env('INDEXNOW_KEY', ''),

    'name'   => env('SITE_NAME', 'Big Times News'),
    'domain' => env('SITE_DOMAIN', 'BigTimesNews.com'),

    // Mailboxes (Google ko real, kaam karta hua email dikhna chahiye)
    'contact_email'     => env('SITE_CONTACT_EMAIL', 'contact@bigtimesnews.com'),
    'privacy_email'     => env('SITE_PRIVACY_EMAIL', env('SITE_CONTACT_EMAIL', 'contact@bigtimesnews.com')),
    'corrections_email' => env('SITE_CORRECTIONS_EMAIL', env('SITE_CONTACT_EMAIL', 'contact@bigtimesnews.com')),

    // Optional physical / mailing address. Khali chhorein to page par show nahi hoga.
    'address' => env('SITE_ADDRESS', ''),

    // Terms of Service ke liye governing law (apne mulk/jurisdiction ke mutabiq)
    'governing_law' => env('SITE_GOVERNING_LAW', 'Pakistan'),

    // Sirf wahi social links show hongi jin ki value set ho (footer + schema)
    'social' => [
        'facebook'  => env('SITE_FACEBOOK', ''),
        'x'         => env('SITE_X', ''),
        'instagram' => env('SITE_INSTAGRAM', ''),
        'youtube'   => env('SITE_YOUTUBE', ''),
        'linkedin'  => env('SITE_LINKEDIN', ''),
    ],

    // About page par "AI-assisted content" ka transparent section
    // Agar aap AI use nahi karte to .env me SITE_AI_DISCLOSURE=false kar dein.
    'ai_disclosure' => env('SITE_AI_DISCLOSURE', true),

    // Policy dates (sitemap lastmod + page par "Last updated")
    'policies_updated' => env('SITE_POLICIES_UPDATED', '2026-09-28'),
];
