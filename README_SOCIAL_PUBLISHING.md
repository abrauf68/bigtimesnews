# Social Auto-Publishing — Complete Feature (with your 3 changes applied)

Ye poora feature (Stages 1-8) ek zip mein hai, aapke 3 requested changes ke
sath. Root par extract + overwrite karein, migrate karein, aur admin panel se
hi sab kuch configure karein — **koi `.env` key ki zaroorat nahi hai**.

```bash
unzip -o social-publishing-complete.zip -d /path/to/your/project
php artisan migrate
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

---

## Aapke 3 changes — kya kiya gaya

### 1) OAuth callback ab public route hai
`https://yourdomain.com/dashboard/social/callback/{platform}` (auth ke andar)
ko hata kar ab ye hai:

```
https://yourdomain.com/social/callback/{platform}
```

Ye route `auth` middleware se bahar hai (koi login check nahi), sirf session
mein save hua random `state` verify hota hai — isliye security waisi hi
rehti hai, bas OAuth provider ka redirect ab kisi auth-wall se block nahi
hoga. Developer console mein **redirect URI is naye format mein hi save
karein** (neeche har platform ke section mein updated URL hai).

`Connect` button abhi bhi admin panel (`/dashboard/social`) mein hi hai, aur
wahi auth-protected hai — sirf **callback** wala hissa public hua hai.

### 2) Per-post toggle hata diya, sirf platform-level enable/disable
Post create/edit page se "Social Auto-Publishing" checkboxes section poori
tarah hata diya gaya hai. Ab control sirf ek jagah hai:
**`/dashboard/social` (Accounts page)** — har platform ka apna
**Enabled/Disabled** button. Jo platform enabled hai, publish hone par sirf
usi par post jayegi; disabled platform har post ke liye automatically skip
ho jayega.

### 3) Sab credentials ab database se, `.env` ki zaroorat nahi
Har platform (X, Facebook, Instagram, LinkedIn, Pinterest, Tumblr, Reddit)
ka **Client ID / Client Secret** aur platform-specific extra settings
(Page ID, Board ID, Organization URN, Blog identifier, Reddit
username/user-agent) ab **`/dashboard/social` Accounts page** ke andar, har
platform ke card mein ek chhota form se save hote hain — seedha database
mein (`client_secret` encrypted store hota hai, jaisa access/refresh tokens
already hote hain).

`config/social.php` mein ab koi `env()` nahi hai — sirf non-secret cheezein
(character limits, image size/format requirements) reh gayi hain.

**Kaise use karein:** Accounts page kholein → jis platform ko connect karna
hai uska Client ID/Secret (aur agar chahiye to extra field jaise Board ID)
bharein → "Save Credentials" → phir "Connect" button dabayein → provider ke
authorize page par redirect hoga → permission dene ke baad wapas aa jayega.

Instagram ka apna credentials form nahi hai — wo automatically Facebook wale
Client ID/Secret hi use karta hai (yehi Meta ka asal tareeqa hai, ek hi App
dono control karta hai).

---

## Baqi sab (Stages 1-8) waisa hi hai jaisa pehle deliver hua

- Sirf pehli dafa publish trigger, kabhi double-post nahi, ek platform fail
  ho to baaki na rukein
- Claude se har platform ka alag SEO caption (language same, invented facts
  nahi, keyword+CTA+link, platform limits)
- meta_image suitability check, unsuitable ho to reason ke sath skip
- Caption ek dafa save, retry par regenerate nahi; Claude fail ho to
  meta_title/description fallback
- Admin panel: connect/disconnect, health/expiry, caption preview/edit,
  per-post status+link, retry button
- Auto-retry (5 tries, backoff), invalid token par account unhealthy +
  admin email, har ghante auto token-refresh
- Reddit sirf admin-approved subreddits par
- og:title/description/image/twitter:card/canonical (pehle se maujood tha)
- Koi code comment nahi

---

## Naye/modified files is update mein

**Naye:** `database/migrations/2026_09_29_000006_...` (client_id/secret/settings
columns), `app/Support/Social/PlatformCredentials.php`

**Modified:** `config/social.php` (env hata diya), `app/Models/SocialPlatformAccount.php`,
saare 7 `app/Support/Social/OAuth/*.php`, 5 drivers (`FacebookPublisher`,
`InstagramPublisher`, `LinkedInPublisher`, `PinterestPublisher`, `TumblrPublisher`,
`RedditPublisher`), `app/Support/Social/Drivers/AbstractHttpPublisher.php`,
`app/Http/Controllers/Dashboard/Social/SocialAccountController.php`,
`resources/views/dashboard/social/accounts.blade.php`, `routes/web.php`,
`app/Http/Controllers/Dashboard/PostController.php`,
`resources/views/dashboard/posts/{create,edit}.blade.php`,
`app/Support/Social/ClaudeCaptionGenerator.php` (Claude key/model bhi ab
sirf DB se — AI Blog settings wale hi `claude_api_key` reuse hota hai).

---

## Developer console setup — updated redirect URIs

Har platform ke developer console mein **ye naya URL** save karein (auth
wala purana URL kaam nahi karega ab):

| Platform | Redirect URI |
|---|---|
| X | `https://yourdomain.com/social/callback/x` |
| Facebook | `https://yourdomain.com/social/callback/facebook` |
| Instagram | `https://yourdomain.com/social/callback/instagram` |
| LinkedIn | `https://yourdomain.com/social/callback/linkedin` |
| Pinterest | `https://yourdomain.com/social/callback/pinterest` |
| Tumblr | `https://yourdomain.com/social/callback/tumblr` |
| Reddit | `https://yourdomain.com/social/callback/reddit` |

Baqi App-registration steps (Products enable karna, App Review, scopes)
pehle jaisi hi hain — sirf Client ID/Secret ab `.env` mein nahi, admin panel
mein jaake save karni hain.

Reddit approve-subreddit workflow waisa hi hai: connect karne ke baad
`/dashboard/social/subreddits` par jaake subreddits add + approve karein.
