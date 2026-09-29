# Social Auto-Publishing — Stage 1: Foundation

Is stage mein koi post kahin bhi actually post nahi hota abhi — ye sirf woh
foundation hai jis par Stage 2 se aagey sab kuch bana jayega: database
schema, models, encrypted token storage, aur har platform ki config/limits
ka ek central registry.

Extract instructions Stage 1 wale patch-zip pattern jaisi hi hain: root par
extract + overwrite karein, phir migrate karein.

```bash
unzip -o social-stage1.zip -d /path/to/your/project
```

---

## Is stage mein kya bana

### Naye files
```
database/migrations/2026_09_29_000001_create_social_platform_accounts_table.php
database/migrations/2026_09_29_000002_create_social_post_targets_table.php
database/migrations/2026_09_29_000003_create_reddit_allowed_subreddits_table.php
database/migrations/2026_09_29_000004_add_social_dispatched_at_to_posts_table.php
app/Enums/SocialPlatform.php
app/Models/SocialPlatformAccount.php
app/Models/SocialPostTarget.php
app/Models/RedditAllowedSubreddit.php
config/social.php
.env.social.example   (in-code .env keys — apni actual .env mein copy karein)
```

### Modified files
```
app/Models/Post.php   -> social_dispatched_at field, socialTargets() relation, needsSocialDispatch() helper
```

---

## Database design (3 nayi tables)

**`social_platform_accounts`** — har platform ka ek row (max 7 rows: x,
facebook, instagram, linkedin, pinterest, tumblr, reddit). Access/refresh
tokens `encrypted` cast ke through DB mein encrypted store hote hain
(Laravel APP_KEY use karta hai) — requirement #10 yahin se poora hota hai.
`health` column unhealthy accounts track karta hai, `is_enabled` admin ka
on/off toggle hai.

**`social_post_targets`** — har post ke har enabled platform ke liye ek row.
`UNIQUE(post_id, platform)` constraint database level par guarantee karta
hai ke ek post ek platform par kabhi 2 dafa post nahi ho sakta (requirement
#1 ka core). Yahin caption, status, error, aur external post URL save hote
hain.

**`reddit_allowed_subreddits`** — allow-list + admin approval flag
(requirement #8), Stage 8 mein use hogi.

**`posts.social_dispatched_at`** — jab tak ye null hai, post "first-time
publish" trigger ke liye eligible hai. Ek dafa dispatch hone ke baad set ho
jata hai, isliye edits par dobara trigger nahi hota (requirement #1).

---

## `config/social.php`

Har platform ka caption character limit, image requirements (size/format/
aspect ratio) aur credential env-keys ek jagah define hain — Stage 3/4/5
yahin se values uthayenge, taake requirement #2 aur #3 ki limits centrally
maintain ho sakein.

---

## Setup steps

### 1) Files extract karke migrate karein
```bash
php artisan migrate
```

### 2) `.env.social.example` ki keys apni asal `.env` mein copy karein
Abhi sab khali rakh sakte hain — values Stage 2 onwards, jab hum har
platform ka connect-flow banayenge, tab bharenge.

---

## Ab developer console par kya karna hai (Stage 2 shuru karne se pehle)

Stage 2 mein hum OAuth "connect account" flow banayenge, is liye har
platform par ek **developer/app registration** chahiye hogi. Abhi sirf
account bana kar app register kar lein — Client ID/Secret jahan milen wahan
note kar lein, hum Stage 2 mein unko `.env` mein daalenge.

| Platform | Kahan jaayein | Kya banana hai |
|---|---|---|
| **X (Twitter)** | developer.x.com → apna app banayein (Free/Basic tier chahiye posting ke liye) | OAuth 2.0 confidential client, callback URL `https://yourdomain.com/dashboard/social/x/callback`, scopes: `tweet.write`, `users.read`, `offline.access` |
| **Facebook + Instagram** | developers.facebook.com → naya App (type: Business) | Products add: "Facebook Login" aur "Instagram Graph API". Aapka Facebook Page aur us se linked Instagram **Business/Creator** account chahiye. Redirect URI: `https://yourdomain.com/dashboard/social/facebook/callback` |
| **LinkedIn** | developer.linkedin.com → naya App | Company Page se link karein, "Share on LinkedIn" + "Sign In with LinkedIn using OpenID Connect" products request karein. Redirect URI: `https://yourdomain.com/dashboard/social/linkedin/callback` |
| **Pinterest** | developers.pinterest.com → naya App | Scopes: `boards:read`, `pins:write`. Ek Board bana lein jahan pins jayenge. Redirect URI: `https://yourdomain.com/dashboard/social/pinterest/callback` |
| **Tumblr** | tumblr.com/oauth/apps → naya App | OAuth 2.0 app, callback URL `https://yourdomain.com/dashboard/social/tumblr/callback` |
| **Reddit** | reddit.com/prefs/apps → naya App (type: "web app") | Redirect URI: `https://yourdomain.com/dashboard/social/reddit/callback`. Note: Reddit posting ek dedicated bot/account se karna behtar hai apni main identity se alag |

**Zaroori:** Facebook/Instagram aur Pinterest jaisi platforms "Live mode"
mein posting API use karne se pehle **App Review** maangti hain (permissions
approve karwani parti hain) — ye process kuch din le sakta hai, isliye is
stage ke turant baad hi shuru kar dein taake Stage 6 (admin panel connect
flow) tak ready ho.

Jab ye app registrations ho jayein, mujhe bata dein — main Stage 2 (publish
trigger + idempotent queue architecture) shuru kar dunga.
