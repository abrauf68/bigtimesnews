# AI Blog Automation + SEO Fixes — what's in this zip & how to install it

This zip contains **only new/changed files**, in two parts:
- **Part A** — the AI blog automation feature (Google Trends → Claude Sonnet/Haiku → Unsplash → draft/publish → email).
- **Part B** — the SEO fixes and improvements from the site audit.

Copy everything into your project at the same relative paths (overwrite files that already exist).

---

## Part A — AI Blog Automation

### A1. New files (just add them)
```
database/migrations/2026_09_24_000001_create_jobs_table.php
database/migrations/2026_09_24_000002_create_ai_blog_settings_table.php
database/migrations/2026_09_24_000003_create_ai_blog_topics_table.php
database/migrations/2026_09_24_000004_add_ai_fields_to_posts_table.php
app/Models/AiBlogSetting.php
app/Models/AiBlogTopic.php
app/Services/AiBlog/TrendService.php
app/Services/AiBlog/ClaudeService.php
app/Services/AiBlog/UnsplashService.php
app/Jobs/GenerateAiBlogPostJob.php
app/Mail/AiBlogDraftsReadyMail.php
resources/views/emails/ai_blog_drafts_ready.blade.php
app/Console/Commands/RunAiBlogAutomation.php
app/Console/Commands/SendAiBlogSummary.php
resources/views/dashboard/settings/sections/ai-blog-setting.blade.php
```

### A2. Modified files (overwrite the existing ones)
```
app/Models/Post.php                                   -> added source/ai_blog_topic_id fields + relation + scope
app/Console/Kernel.php                                 -> added the 3 scheduled tasks
app/Http/Controllers/Dashboard/SettingController.php   -> added updateAiBlogSettings() + runAiBlogNow()
resources/views/dashboard/settings/index.blade.php     -> added the new "AI Blog Automation" tab
public/assets/js/custom-js/settings.js                 -> registered the new tab in the tab switcher
database/seeders/SettingSeeder.php                     -> seeds a default ai_blog_settings row
.env.example                                            -> QUEUE_CONNECTION changed to "database" (reference only)
routes/web.php                                          -> shared with Part B, see below
```

### A3. What it does
1. `ai-blog:run` (daily, cron-driven) pulls trending topics from Google Trends' free daily RSS feed
   for your chosen country (or a blended "Global" list), skips topics already written about, and
   dispatches one queued job per topic (up to your daily limit).
2. Each job: **Claude Sonnet** drafts a full SEO-structured article → **Claude Haiku** does a
   humanize + SEO-QA rewrite pass → **Unsplash** supplies the main/meta image → saved as a `Post`
   (draft or published, per your setting).
3. `ai-blog:send-summary` emails you once the day's batch finishes, listing what was generated
   (with edit links) and anything that failed.

### A4. Admin panel
Dashboard → Settings → **AI Blog Automation** tab: enable/disable, blogs/day, daily run time,
draft-vs-auto-publish, notify email, "post as" user, trend country (incl. Global), trends provider,
Claude API key + models, Unsplash key, default category/author, plus a **Run Now** button and a
recent-activity log.

---

## Part B — SEO Fixes

### B1. New files
```
app/Http/Controllers/Frontend/SitemapController.php
resources/views/frontend/sitemap/index.blade.php
resources/views/frontend/sitemap/news.blade.php
```

### B2. Modified files
```
resources/views/frontend/layouts/meta.blade.php          -> fixed the domain bug, dynamic OG image, sitemap link, schema stack
resources/views/frontend/layouts/master.blade.php         -> fixed lang="zxx" bug, added sitewide Organization/WebSite JSON-LD
resources/views/frontend/sections/featured-slider.blade.php -> fixed LCP: first hero slide now loads eagerly instead of JS-lazy
resources/views/frontend/pages/news/single-post.blade.php -> per-article OG image + NewsArticle + BreadcrumbList JSON-LD
resources/views/frontend/pages/news/single-category.blade.php -> BreadcrumbList JSON-LD
public/robots.txt                                          -> added Sitemap: directives, blocked /dashboard, /login, /register
public/assets/img/social-og.png                            -> resized to standard 1200x630 and compressed (1.27MB -> ~413KB)
```

### B3. What was fixed and why

**Bugs (were actively hurting you):**
- `meta.blade.php` had the homepage `og:url` hardcoded to `https://siteffects.com/` — a leftover
  from a different project's template. Every Facebook/LinkedIn/Twitter share of your homepage was
  sending crawlers to the wrong domain. Fixed to use your real domain dynamically via `url('/')`.
- `master.blade.php` had `<html lang="zxx">`. `zxx` is the ISO code for **"no linguistic content"** —
  you were telling every crawler and screen reader your English news site has no language. Now set
  dynamically from your System Settings language.

**High-impact additions (previously missing entirely):**
- **Structured data (JSON-LD)** — there was zero `schema.org` markup anywhere in the codebase.
  Added: sitewide `Organization` + `WebSite` (with `SearchAction` tied to your real `/news?search=`
  functionality), per-article `NewsArticle` schema (headline, image, author, publisher, dates), and
  `BreadcrumbList` on article + category pages. This is what makes articles eligible for Google
  Discover, Top Stories, and rich results.
- **XML sitemaps** — `/sitemap.xml` (all pages/categories/published posts, cached hourly) and
  `/news-sitemap.xml` (a proper Google News sitemap, auto-limited to posts published in the last 48
  hours per Google's spec). `robots.txt` now references both.
- **Per-article social image** — article pages were using one generic static image for every share.
  Now uses that post's actual `main_image`/`meta_image` — matters a lot once the AI automation is
  producing a real photo for every post.

**Performance:**
- The homepage's hero slider marks every slide image `loading: lazy` via the theme's JS lazy-loader —
  including the **first slide, which is your Largest Contentful Paint element** and is visible
  immediately. JS-based lazy loading delays that image behind JS execution instead of the browser
  requesting it right away. Fixed: the first slide now loads eagerly with `fetchpriority="high"`;
  other slides stay lazy since they're off-screen until swiped to.
- `social-og.png` was 1.27MB at a non-standard size. Resized to the standard 1200×630 OG dimensions
  and compressed to ~413KB. Note: this doesn't affect on-page load speed (social crawlers fetch it
  separately from the page), it's just faster/more reliable for link-preview generation.
- I checked `app-head-bs.js` in `<head>` (not deferred) before touching it — it's intentionally
  blocking to set dark-mode/breakpoint classes before first paint and avoid a flash of wrong theme.
  Left as-is; "fixing" it would introduce a visible flicker.

### B4. After deploying
1. Visit `https://yourdomain.com/sitemap.xml` and `/news-sitemap.xml` to confirm they render.
2. Submit both to Google Search Console (Sitemaps section) for your US property.
3. Validate the structured data with Google's Rich Results Test on a live article URL.
4. `robots.txt` currently points to `https://bigtimesnews.com/sitemap.xml` — **double-check this
   matches your actual live domain** and edit if not.

---

## Combined install steps

```bash
# 1. Copy all files above into your project (overwrite where noted)

# 2. Run the new migrations
php artisan migrate

# 3. In your real .env, switch the queue driver to database:
QUEUE_CONNECTION=database

# 4. Clear caches
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

**Shared hosting cron — one entry drives everything (automation + queue processing):**
```
* * * * * cd /home/yourusername/your-app && php artisan schedule:run >> /dev/null 2>&1
```
