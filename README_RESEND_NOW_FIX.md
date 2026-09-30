# Fix — Manual "Resend Now" button for failed/skipped social posts

Pehle "Retry" button sirf ek job **queue** karta tha — jo sirf tab chalta
tha jab aapka cron/queue-worker agli dafa chale (aapke setup mein har 5
minute). Isi wajah se button dabane par kuch turant hota nahi lagta tha.

Ab har failed/skipped platform ke aagey **"Resend Now"** button hai jo
click karte hi **usi request mein, bina kisi queue ke**, seedha us platform
par post karne ki koshish karta hai aur turant result (success/fail/skip
reason) dikhata hai.

```bash
unzip -o social-resend-now-fix.zip -d /path/to/your/project
php artisan route:clear && php artisan view:clear
```

Koi nayi migration nahi hai.

---

## Modified files
```
app/Services/Social/SocialPublishingService.php   -> naya resendNow() method (synchronous publish, koi job dispatch nahi)
app/Http/Controllers/Dashboard/Social/SocialPostStatusController.php -> naya resendNow() action
routes/web.php                                     -> naya route: POST /dashboard/social/targets/{target}/resend-now
resources/views/dashboard/social/posts.blade.php   -> button ka naam "Resend Now" aur naye route par point karta hai
```

Purana "Retry" (queued) route/method (`targets.retry` / `SocialPostStatusController::retry()`)
waisa hi maujood hai, bas ab UI mein use nahi ho raha — agar kabhi
background-retry ki zaroorat pade to wo available hai.

---

## Note
Kuch platforms (khaaskar LinkedIn, jo 3 sequential API calls karta hai)
button click par 5-15 second tak le sakte hain kyunki ab ye seedha usi
request mein ho raha hai — button click hote hi "Sending..." dikhega aur
dobara-click disable ho jata hai jab tak result na aa jaye.
