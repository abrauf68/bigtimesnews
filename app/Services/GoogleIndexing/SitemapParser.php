<?php

namespace App\Services\GoogleIndexing;

use DOMDocument;
use DOMXPath;

/** Pure sitemap XML parser (urlset and sitemapindex). */
class SitemapParser
{
    /**
     * @return array{type:string, sitemaps:array<int,string>, urls:array<int,array{loc:string,lastmod:?string}>}
     */
    public static function parse(string $xml): array
    {
        $out = ['type' => 'invalid', 'sitemaps' => [], 'urls' => []];

        $xml = trim($xml);
        if ($xml === '') {
            return $out;
        }

        $previous = libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        // LIBXML_NONET blocks network access; entity loading stays disabled by default in modern libxml.
        $loaded = $dom->loadXML($xml, LIBXML_NONET | LIBXML_NOCDATA);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (!$loaded || !$dom->documentElement) {
            return $out;
        }

        $xpath = new DOMXPath($dom);
        $root = strtolower($dom->documentElement->localName);

        if ($root === 'sitemapindex') {
            $out['type'] = 'index';
            foreach ($xpath->query("//*[local-name()='sitemap']/*[local-name()='loc']") as $node) {
                $loc = trim($node->textContent);
                if ($loc !== '') {
                    $out['sitemaps'][] = $loc;
                }
            }

            return $out;
        }

        if ($root === 'urlset') {
            $out['type'] = 'urlset';
            foreach ($xpath->query("//*[local-name()='url']") as $urlNode) {
                $loc = null;
                $lastmod = null;
                foreach ($urlNode->childNodes as $child) {
                    if (!($child instanceof \DOMElement)) {
                        continue;
                    }
                    if ($child->localName === 'loc') {
                        $loc = trim($child->textContent);
                    } elseif ($child->localName === 'lastmod') {
                        $lastmod = trim($child->textContent) ?: null;
                    }
                }
                if ($loc) {
                    $out['urls'][] = ['loc' => $loc, 'lastmod' => $lastmod];
                }
            }
        }

        return $out;
    }
}
