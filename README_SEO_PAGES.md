# SEO Pages Patch — About, Contact, Privacy Policy, Terms of Service

Ye zip sirf **naye aur changed files** hain (aapke `README_CHANGES.md` wale pattern jaisa).
Isko apne Laravel project ke root mein extract karein aur jahan file already maujood ho,
usay **overwrite** kar dein.

```bash
unzip -o seo-pages-patch.zip -d /path/to/your/project
```

---

## Kya add/change hua

### Naye files (sirf add karni hain)
```
config/site.php
app/Http/Controllers/Frontend/PageController.php
app/Mail/ContactMessageMail.php
resources/views/emails/contact_message.blade.php
resources/views/frontend/pages/static/layout.blade.php
resources/views/frontend/pages/static/about.blade.php
resources/views/frontend/pages/static/contact.blade.php
resources/views/frontend/pages/static/privacy-policy.blade.php
resources/views/frontend/pages/static/terms-of-service.blade.php
```

### Modified files (overwrite karni hain — existing ke sath merge ho chuki hain)
```
routes/web.php                                 -> 5 nayi routes add hui hain (about, contact, contact.submit, privacy, terms)
resources/views/frontend/layouts/footer.blade.php -> footer ke "#" links ab real pages ko point karte hain
app/Http/Controllers/Frontend/SitemapController.php -> sitemap.xml mein 4 nayi URLs add hui hain
```

> Agar aap ne in files (`routes/web.php`, `footer.blade.php`, `SitemapController.php`)
> mein khud bhi changes kiye hain, to seedha overwrite karne se pehle diff zaroor dekh lein.

---

## Naye routes (aapki site par live URLs)

| Page            | URL                     | Route name              |
|------------------|-------------------------|--------------------------|
| About Us         | `/about`                | `frontend.about`         |
| Contact Us       | `/contact` (GET + POST) | `frontend.contact`       |
| Privacy Policy   | `/privacy-policy`       | `frontend.privacy`       |
| Terms of Service | `/terms-of-service`     | `frontend.terms`         |

Ye sab `frontend.` group ke andar hain, isliye aapke existing header/footer/nav design
aur dark-mode automatically inherit hoga (same `master` layout use ho raha hai).

---

## Setup steps

### 1) `.env` mein ye keys add karein (sab optional hain, defaults already set hain)

```env
SITE_NAME="Big Times News"
SITE_DOMAIN="BigTimesNews.com"
SITE_CONTACT_EMAIL=contact@bigtimesnews.com
SITE_PRIVACY_EMAIL=privacy@bigtimesnews.com
SITE_CORRECTIONS_EMAIL=corrections@bigtimesnews.com
SITE_ADDRESS=""
SITE_GOVERNING_LAW="Pakistan"
SITE_FACEBOOK=""
SITE_X=""
SITE_INSTAGRAM=""
SITE_YOUTUBE=""
SITE_LINKEDIN=""
SITE_AI_DISCLOSURE=true
SITE_POLICIES_UPDATED=2026-09-28
```

**Zaroor karein:** `SITE_CONTACT_EMAIL` ko apni asli, kaam karti hui email pe set karein —
Google aur users dono ko real contact chahiye hota hai, `example.com` wali email trust nahi banati.

### 2) Cache clear karein (kyunki naya config file add hua hai)

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 3) Test karein
- `/about`, `/contact`, `/privacy-policy`, `/terms-of-service` khol kar dekhein.
- Contact form se ek test message bhejein — ye `SITE_CONTACT_EMAIL` par mail karega
  (aapki existing `EmailSetting`/SMTP configuration use hoti hai, koi naya mail driver nahi chahiye).
- `/sitemap.xml` khol kar check karein ke 4 nayi URLs list mein aa gayi hain.

---

## SEO ke liye kya kiya gaya hai

- Har page par unique **meta title / description / keywords**, canonical URL (already aapke
  `meta.blade.php` se automatic hai), Open Graph aur Twitter card tags.
- **Structured data (JSON-LD)**: About = `AboutPage` + `NewsMediaOrganization`,
  Contact = `ContactPage` + `ContactPoint`, Privacy/Terms = `WebPage` with `dateModified`,
  har page par `BreadcrumbList` bhi hai.
- Content asli, unique aur substantial hai (thin/duplicate content nahi) — Google E-E-A-T
  (transparency, editorial standards, corrections policy, contact info) ke mutabiq likha gaya hai.
- Contact form mein honeypot spam-protection hai (aapke existing reCAPTCHA setting se conflict nahi karta).
- 4 pages `sitemap.xml` mein automatically add ho jate hain, footer se link hote hain (Google ko
  internal-linking se discover karna asaan ho jata hai).
- Dark mode aur mobile-responsive — aapke existing design tokens (Tailwind classes) use kiye hain,
  koi naya CSS framework nahi.

---

## Agla step (recommended, optional)

Abhi in pages ka content is zip mein already static Blade views mein likha hua hai (database
se nahi aata) — is liye aapko dashboard se edit karne ki zaroorat nahi, direct deploy ho sakta hai.
Agar aap future mein inko dashboard se edit karne layak (jaise `pages` table wale `home`/`news`
pages) banana chahen, to `Page` model use kar ke inhe bhi DB-driven bana sakte hain — abhi ke liye
ye approach simple aur fast-shipping ke liye rakha gaya hai.
