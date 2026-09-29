# Social Auto-Publishing — Complete Feature (Stages 1-8)

Ye poora feature ek zip mein hai. Root par extract + overwrite karein, migrate
karein, `.env` fill karein, aur developer console setup (neeche) karein — phir
sab ek sath test kar sakte hain.

```bash
unzip -o social-publishing-complete.zip -d /path/to/your/project
php artisan migrate
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

`.env.social.example` ki saari keys apni `.env` mein copy karein.

---

## Feature ka khulasa (requirement se mapping)

| # | Requirement | Kahan implement hua |
|---|---|---|
| 1 | Sirf pehli dafa trigger, kabhi double-post nahi, ek platform block na kare | `posts.social_dispatched_at` (atomic claim) + `social_post_targets` unique constraint + `PostObserver` + 7 independent queued jobs |
| 2 | Har platform ke liye alag SEO caption (Claude se), platform limits respect | `ClaudeCaptionGenerator` — language same as article, no invented facts, keyword, CTA, link, char-limits `config/social.php` se |
| 3 | Image = meta_image, unsuitable ho to skip + reason | `ImageSuitabilityChecker` |
| 4 | Caption save ho, retry par dobara generate na ho; fail ho to fallback | `SocialPublishingService::publishTarget()` — caption empty ho tabhi generate; `ClaudeCaptionGenerator` khud fail hone par `FallbackCaptionGenerator` (meta_title+meta_description) call karta hai |
| 5 | Per-post platform toggles | `create.blade.php` / `edit.blade.php` checkboxes + `PostController::syncSocialTargets()` |
| 6 | Admin panel: connect/disconnect, enable/disable, health/expiry, caption preview/edit, per-post status + link, retry | `/dashboard/social` (Accounts, Post Status, Reddit Subreddits pages) |
| 7 | Auto-retry temporary errors, unhealthy on bad token + notify admin, auto-refresh tokens | `PublishToPlatformJob` (5 tries, backoff), `RefreshSocialTokens` command (hourly), `SocialAccountUnhealthyMail` |
| 8 | Reddit sirf approved subreddits, admin approval ke baad | `RedditAllowedSubreddit` + `RedditSubredditController` + gate in `SocialPublishingService`/`RedditPublisher` |
| 9 | og:title/description/image(meta_image)/twitter:card/canonical | **Aapke codebase mein ye already maujood tha** (`meta.blade.php` + `single-post.blade.php`) — humne verify kiya, koi change ki zaroorat nahi thi |
| 10 | Koi comment nahi, secrets .env mein, tokens encrypted | Poore code mein comments nahi likhe; sab credentials `config/social.php` → `env()`; tokens `encrypted` Eloquent cast se DB mein encrypted store hote hain |

---

## Sab naye/modified files (60 files)

**Naye:** migrations (5), Enums, Contracts, Exceptions, Support\Social\* (captions,
image-checker, publisher manager, 7 drivers, OAuth manager + 7 OAuth clients),
Services\Social\SocialPublishingService, Jobs\Social\* (2), Console\Commands (2),
Mail + email view, Dashboard\Social controllers (3) + views (3).

**Modified:** `config/social.php`, `app/Models/Post.php`, `app/Models/SocialPostTarget.php`,
`app/Observers/PostObserver.php`, `app/Providers/AppServiceProvider.php`,
`app/Http/Controllers/Dashboard/PostController.php`,
`resources/views/dashboard/posts/{create,edit}.blade.php`,
`resources/views/layouts/sidebar.blade.php`, `routes/web.php`, `app/Console/Kernel.php`.

---

## Kaise kaam karta hai (end-to-end)

1. Post edit/create form mein editor 7 platforms mein se enable/disable choose karta hai (default: sab on).
2. "Publish" toggle dabate hi (`PostController::updateStatus` ya `store`/`update` jab status published ho), `PostObserver` ek dafa `DispatchSocialPublishingJob` queue karta hai — DB-level atomic claim guarantee karta hai ye sirf ek dafa ho.
3. Har enabled + connected + healthy platform ke liye alag `PublishToPlatformJob` queue hota hai.
4. Har job: image suitability check → Reddit ho to approved-subreddit check → caption generate (Claude, ya fail hone par fallback) aur turant save → platform API call.
5. Success: `posted` + link save. Fail: retry (temporary) ya turant `failed`+account `unhealthy`+admin email (invalid token) ya `skipped`+reason (image/account/subreddit issue).
6. Admin `/dashboard/social` se har post ka status dekh sakta hai, caption edit kar sakta hai, retry dabaa sakta hai.
7. Har ghante `social:refresh-tokens` un accounts ke tokens refresh karta hai jinki expiry 24 ghante ke andar hai; refresh fail ho to account unhealthy + admin ko email.

Queue/scheduler ke liye koi naya cron nahi chahiye — aapka existing single
`schedule:run` cron entry hi sab kuch chala dega (humne `default` queue aur
existing `Kernel.php` ke schedule mein hi add kiya hai).

---

## Test karne ka tareeqa

```bash
php artisan social:dispatch {post_id}
php artisan queue:work --queue=default --stop-when-empty
```

Ya seedha dashboard se ek post publish karein aur `/dashboard/social/posts/status`
par status dekhein.

---

## Developer console setup — har platform (zaroori, live posting ke liye)

Neeche har platform ka: kahan jaayein, kya banayein, konsa redirect URI/scope
chahiye, aur `.env` mein kya bharna hai.

### X (Twitter)
- **developer.x.com** → naya App/Project banayein (posting ke liye kam az kam **Basic** paid tier chahiye — Free tier read-only hai)
- App settings → **User authentication settings** → OAuth 2.0 ON, type: **Confidential client**
- Redirect URI: `https://yourdomain.com/dashboard/social/callback/x`
- Scopes: `tweet.read tweet.write users.read offline.access`
- `.env`: `X_CLIENT_ID`, `X_CLIENT_SECRET` (OAuth2 app ke)

### Facebook (aur Instagram usi App se)
- **developers.facebook.com** → naya App, type **Business**
- Products add karein: **Facebook Login**
- App Settings → Basic → App ID/Secret copy karein
- Valid OAuth Redirect URIs: `https://yourdomain.com/dashboard/social/callback/facebook` aur `.../instagram`
- Permissions/App Review maangein: `pages_show_list`, `pages_manage_posts`, `pages_read_engagement`, `instagram_basic`, `instagram_content_publish`, `business_management` — **Live mode** mein jaane se pehle Meta App Review approve karwana zaroori hai (kuch din lagte hain)
- Aapka Facebook Page ready ho aur uske sath ek Instagram **Business/Creator** account linked ho
- `.env`: `FACEBOOK_APP_ID`, `FACEBOOK_APP_SECRET`, `FACEBOOK_PAGE_ID` (optional — agar khali chhora to jo pehla Page mile wahi use hoga)

### LinkedIn
- **developer.linkedin.com** → naya App, apni Company Page se link karein
- Products request karein: **Share on LinkedIn**, **Sign In with LinkedIn using OpenID Connect**
- Redirect URL: `https://yourdomain.com/dashboard/social/callback/linkedin`
- `.env`: `LINKEDIN_CLIENT_ID`, `LINKEDIN_CLIENT_SECRET`, `LINKEDIN_ORGANIZATION_URN` (format: `urn:li:organization:123456`, Company Page admin panel se milega)

### Pinterest
- **developers.pinterest.com** → naya App
- Redirect URI: `https://yourdomain.com/dashboard/social/callback/pinterest`
- Scopes: `boards:read,pins:write,pins:read`
- Ek Board bana lein jahan pins jayenge, uska ID copy karein
- Trial apps sirf apne khud ke account se kaam karte hain — public/business use ke liye **Standard Access** apply karna hoga
- `.env`: `PINTEREST_CLIENT_ID`, `PINTEREST_CLIENT_SECRET`, `PINTEREST_BOARD_ID`

### Tumblr
- **tumblr.com/oauth/apps** → naya App (OAuth 2.0)
- Redirect URL: `https://yourdomain.com/dashboard/social/callback/tumblr`
- `.env`: `TUMBLR_CLIENT_ID`, `TUMBLR_CLIENT_SECRET`, `TUMBLR_BLOG_IDENTIFIER` (e.g. `yourblog.tumblr.com`)

### Reddit
- **reddit.com/prefs/apps** → naya App, type: **web app**
- Redirect URI: `https://yourdomain.com/dashboard/social/callback/reddit`
- **Recommended:** apni main identity se alag ek dedicated bot account banayein posting ke liye
- `.env`: `REDDIT_CLIENT_ID`, `REDDIT_CLIENT_SECRET`, `REDDIT_USERNAME`, `REDDIT_USER_AGENT`
- Connect karne ke baad `/dashboard/social/subreddits` par jaake wo subreddits add + **approve** karein jahan posts jani chahiye — jab tak koi bhi approved na ho, Reddit har post par `skipped` rahega (requirement #8)

### Claude (captions ke liye)
Agar aap already AI Blog feature use kar rahe hain to **kuch nahi karna** —
usi settings ka Claude API key reuse ho jayega. Agar nahi, to `.env` mein
`SOCIAL_CLAUDE_API_KEY` bhar dein (console.anthropic.com se key).

---

## Zaroori notes

- **Connect flow** admin panel (`/dashboard/social`) ke "Connect" button se hoga — vahan click karte hi platform ke authorize page par redirect hoga, permission dene ke baad wapas aapke dashboard par aa jayega.
- Facebook/Instagram/Pinterest App Review mein kuch din lag sakte hain — jab tak approve na ho, app sirf "Development mode" mein sirf aapke apne test account se kaam karega.
- X ka media-upload endpoint aur LinkedIn ka asset-upload flow API version ke hisab se thoda vary kar sakta hai — agar koi platform token milne ke baad bhi post fail kare, `/dashboard/social/posts/status` ka error message dekh kar us driver file (`app/Support/Social/Drivers/...`) mein exact endpoint/response-shape adjust karna pad sakta hai, kyunki main live test nahi kar saka.
- Sab kuch ek zip mein hai — ab aap ek sath sab test kar sakte hain jaisa aapne kaha tha.
