# AI Blog Automation — Multiple Time Slots (Daily Spread-Out Publishing)

Pehle: ek hi `run_time` + `daily_post_limit` hota tha, is liye din ka **sara
quota ek hi waqt** par generate/publish ho jata tha (jaise agar limit 10 thi
to 10 ke 10 posts ek sath 3am par ban jate). Ye is masla ko fix karta hai.

Ab: aap `/dashboard/ai-blog/schedules` par **multiple time slots** add kar
sakte hain — har slot apne alag waqt par, apne alag post-count ke sath, aur
chahen to apna alag country/category focus ke sath, **din mein sirf ek dafa**
independently chalta hai. Matlab agar aap 4 slots banayein (9am, 1pm, 5pm,
9pm — har ek mein 2-2 posts), to poore din mein posts spread ho kar aayenge,
sab ek sath nahi.

```bash
unzip -o social-publishing-complete.zip -d /path/to/your/project
php artisan migrate
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

---

## Kaise kaam karta hai

- Naya table `ai_blog_schedules`: har row = ek time slot (`run_time`,
  `post_count`, `is_enabled`, optional `category_id` override, optional
  `trend_country` override, `last_run_date`).
- Command `ai-blog:run` (jo already har 5 minute cron se chalta hai) ab check
  karta hai: agar koi enabled time-slot hai to har slot ko apne waqt par,
  apne post-count ke sath, **independently** trigger karta hai — ek slot ka
  run doosre slot ko affect nahi karta, aur har slot din mein sirf ek dafa
  chalta hai (`last_run_date` per-slot track hota hai, poore settings ki
  tarah nahi).
- **Backward-compatible:** agar koi time-slot add nahi kiya (table khali
  hai), to system automatically purane single `run_time`/`daily_post_limit`
  waale tareeqe par chalta rahega — kuch bhi break nahi hoga.
- Har slot ka apna optional **Category** (agar diya to us slot se ban'ne
  wali posts ke liye fallback category ban jata hai — Claude phir bhi content
  se best-fit category khud detect karta hai, ye sirf tab use hota hai jab
  Claude ka detection kisi active category se match na kare) aur apna optional
  **Country** (trending topics kis mulk se fetch hon, us slot ke liye).

## Admin panel

`/dashboard/ai-blog/schedules` (AI Blog settings page ke header mein
**"Manage Time Slots"** button se seedha pahunch sakte hain):
- Naya slot add karein (time + post count + optional category + optional country)
- Har slot inline edit/save kar sakte hain
- Enable/Disable toggle
- Remove
- Har slot ka "last run" status dikhta hai

## Naye/modified files

**Naye:** `database/migrations/2026_09_30_000001_create_ai_blog_schedules_table.php`,
`database/migrations/2026_09_30_000002_add_category_id_to_ai_blog_topics_table.php`,
`app/Models/AiBlogSchedule.php`, `app/Http/Controllers/Dashboard/AiBlogScheduleController.php`,
`resources/views/dashboard/ai-blog/schedules.blade.php`

**Modified:** `app/Models/AiBlogTopic.php` (category/schedule link),
`app/Console/Commands/RunAiBlogAutomation.php` (multi-slot loop + legacy
fallback), `app/Jobs/GenerateAiBlogPostJob.php` (per-topic category
fallback), `routes/web.php`,
`resources/views/dashboard/settings/sections/ai-blog-setting.blade.php`
("Manage Time Slots" link + clarifying note)

Koi developer-console setup is feature ke liye nahi chahiye — ye purely
internal scheduling logic hai.
