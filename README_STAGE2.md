# Social Auto-Publishing — Stage 2: Publish Trigger + Idempotent Queue

Ye stage requirement #1 poora karta hai: **post publish hote hi automatically
trigger, sirf pehli dafa, kabhi double-post nahi, ek platform ki failure
doosri platforms ko block nahi karti.** Abhi tak koi platform API call nahi
hoti — targets create hote hain, caption ban jata hai (Stage 3 tak fallback
version), aur sab platforms "not available yet" show karengi jab tak Stage 5
mein unke drivers nahi ban jate. Poora pipeline end-to-end testable hai.

```bash
unzip -o social-stage2.zip -d /path/to/your/project
```

Is stage mein koi nayi migration nahi hai — Stage 1 ka schema already sab
kuch cover karta hai.

---

## Naye files
```
app/Contracts/Social/SocialPublisherContract.php
app/Contracts/Social/CaptionGeneratorContract.php
app/Exceptions/Social/SkipTargetException.php
app/Exceptions/Social/TemporarySocialException.php
app/Exceptions/Social/InvalidTokenSocialException.php
app/Support/Social/FallbackCaptionGenerator.php
app/Support/Social/SocialPublisherManager.php
app/Services/Social/SocialPublishingService.php
app/Jobs/Social/DispatchSocialPublishingJob.php
app/Jobs/Social/PublishToPlatformJob.php
app/Console/Commands/DispatchSocialPublishing.php
```

## Modified files
```
config/social.php               -> 'drivers' map add hua (Stage 5 yahan platform drivers register karega)
app/Observers/PostObserver.php  -> publish hote hi dispatch trigger karta hai
app/Providers/AppServiceProvider.php -> CaptionGeneratorContract ko FallbackCaptionGenerator se bind kiya
app/Models/Post.php             -> (Stage 1 mein already patch ho chuka, agar Stage 1 install nahi kiya to pehle wo zip lagayein)
```

---

## Architecture — requirement #1 kaise poora hota hai

**"Sirf pehli dafa trigger":** `posts.social_dispatched_at` column (Stage 1)
jab tak `NULL` hai, post trigger ke liye eligible hai. `PostObserver`
har `created`/`updated` event par check karta hai — agar status
`published` hai aur `social_dispatched_at` abhi tak null hai, tabhi
`DispatchSocialPublishingJob` queue hota hai. Post edit hone par (jab wo
already published ho chuka) ye column already set hota hai, isliye dobara
trigger nahi hota.

**"Kabhi double-post nahi":** Do parat ka protection hai:
1. **Post-level claim:** `DispatchSocialPublishingJob` ek single atomic SQL
   `UPDATE posts SET social_dispatched_at = NOW() WHERE id = ? AND
   social_dispatched_at IS NULL` chalata hai. Agar 2 jobs race karein
   (theoretically), sirf ek ko row milegi — doosra khud-ba-khud no-op ho
   jayega.
2. **Platform-level constraint:** Stage 1 ki `social_post_targets` table par
   `UNIQUE(post_id, platform)` hai — database level par hi ek post ek
   platform par 2 rows nahi le sakta. Job dispatch se pehle bhi target ka
   current status `posted` check hota hai; agar already posted hai to job
   dispatch hi nahi hota.

**"Ek platform ki failure doosri ko block na kare":** Har platform ka apna
alag `PublishToPlatformJob` hai — ye 7 independent queued jobs hain, ek
dusre se disconnected. Ek platform fail/retry ho raha ho to baaki 6 apna
kaam normally continue karte hain.

---

## Retry behaviour (foundation ke liye)

`PublishToPlatformJob` ko 5 tries milte hain, backoff: 1 min, 5 min, 15 min,
30 min. Har attempt DB mein `attempts` aur `last_attempted_at` save karta
hai. Sab tries khatam hone par `failed()` method target ko permanently
`failed` mark karti hai. Ye basic retry hai — **Stage 7** isko refine karega:
temporary errors (network, rate-limit) vs auth errors (expired token) ko
alag treat karna, aur unhealthy account par admin ko email bhejna.

`InvalidTokenSocialException` throw hote hi account turant `unhealthy` mark
ho jata hai (target bhi `failed`, retry nahi hota — retry karne ka fayda
nahi jab tak token fix na ho). Admin notification email Stage 7 mein add
hogi.

---

## Caption — abhi fallback, Stage 3 replace karega

`FallbackCaptionGenerator` filhal `meta_title` + `meta_description` + post
URL se, platform ki character-limit mein fit karke, ek basic caption bana
deta hai. Ye `CaptionGeneratorContract` implement karta hai — Stage 3 mein
hum sirf ek line change karenge (`AppServiceProvider` ka binding) taake
Claude-based generator use ho, jo khud internally fail hone par isi
Fallback ko call kare (requirement #4).

**Zaroori:** caption target row mein save hote hi permanently reh jata hai
— agar job retry ho, `empty($target->caption)` check ki wajah se caption
dobara generate nahi hota (requirement #4).

---

## Test kaise karein (drivers ke bina hi)

```bash
php artisan social:dispatch {post_id}
```

Ye publish-jaisa hi dispatch chalata hai aur ek table print karta hai — har
platform ka status dikhayega. Abhi expected result: har platform
`skipped` ho ga, reason `"... account is not connected."` (kyunki koi
account connect nahi hua abhi — Stage 6). Ye confirm karta hai ke poora
pipeline (targets create, caption generate & save, gating checks) sahi kaam
kar raha hai.

Queue worker chalayein taake jobs process hon (aapke existing cron/worker
setup se hi ho jayega — humne koi naya queue name use nahi kiya, `default`
queue hi use hoti hai, isliye **koi naya cron/worker setup nahi chahiye**):

```bash
php artisan queue:work --queue=default --stop-when-empty
```

---

## Developer console setup is stage ke liye

**Kuch nahi.** Ye stage pure application-layer architecture hai — koi
external API call nahi hoti. Aap Stage 1 ke README wale app-registrations
(X, Facebook/Instagram, LinkedIn, Pinterest, Tumblr, Reddit) parallel mein
continue kar sakte hain; unki zaroorat **Stage 6 (OAuth connect flow)** mein
padegi.

Ready hon to bata dein — **Stage 3 (Claude se per-platform SEO captions)**
shuru karta hun.
