<?php

namespace App\Support;

class ImageAlt
{
    /**
     * Give every <img> in an article's HTML a descriptive alt attribute.
     *
     * Images that already have a non-empty alt are left alone. For the rest, the
     * alt text is the closest preceding heading (h2-h4) in the article, falling
     * back to the post title, so images in different sections get different,
     * relevant descriptions.
     */
    public static function fill(?string $html, string $title): string
    {
        $html = (string) $html;
        if ($html === '' || stripos($html, '<img') === false) {
            return $html;
        }

        $title = self::clean($title);
        $lastHeading = '';

        return preg_replace_callback(
            '/<h[1-4]\b[^>]*>.*?<\/h[1-4]>|<img\b[^>]*>/is',
            function ($m) use (&$lastHeading, $title) {
                $tag = $m[0];

                if (stripos($tag, '<img') !== 0) {
                    $heading = self::clean(strip_tags($tag));
                    if ($heading !== '') {
                        $lastHeading = $heading;
                    }
                    return $tag;
                }

                // Existing, non-empty alt: keep it.
                if (preg_match('/\balt\s*=\s*(["\'])(.*?)\1/is', $tag, $a) && trim($a[2]) !== '') {
                    return $tag;
                }

                $alt = $lastHeading !== '' ? $lastHeading : $title;
                if ($alt === '') {
                    return $tag;
                }
                if ($lastHeading !== '' && $title !== '' && mb_stripos($lastHeading, $title) === false) {
                    $alt = $lastHeading . ' - ' . $title;
                }
                $alt = e(mb_strimwidth($alt, 0, 125, '', 'UTF-8'));

                // Drop any empty/blank alt, then add the new one.
                $tag = preg_replace('/\s+alt\s*=\s*(".*?"|\'.*?\'|[^\s>]*)/is', '', $tag);

                return preg_replace('/<img\b/i', '<img alt="' . $alt . '"', $tag, 1);
            },
            $html
        );
    }

    protected static function clean(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text));
    }
}
