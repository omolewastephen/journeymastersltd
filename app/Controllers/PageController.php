<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\Content;

final class PageController extends Controller
{
    public function home(): void
    {
        $this->view('pages/home', [
            'title'        => 'Journey Masters Ltd — Travel, Study Abroad & Visa Consultancy',
            'description'  => 'Premium travel, study-abroad, proof of funds and visa consultancy in Abeokuta, Nigeria. Canada, UK, Europe & New Zealand. Book a free consultation.',
            'services'     => Content::services(),
            'destinations' => Content::destinations(),
            'testimonials' => Content::testimonials(),
            'faqs'         => array_slice(Content::faqs(), 0, 5),
            'stats'        => Content::stats(),
            'process'      => Content::process(),
            'posts'        => array_slice(Content::posts(), 0, 3),
            'bodyClass'    => 'page-home',
        ]);
    }

    public function about(): void
    {
        $this->view('pages/about', [
            'title'       => 'About Us — Journey Masters Ltd',
            'description' => 'Meet the team behind Journey Masters Ltd — a credibility partner for study abroad, work permits and visas, based in Abeokuta, Ogun State.',
            'stats'       => Content::stats(),
            'process'     => Content::process(),
        ]);
    }

    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $base  = rtrim(config('app.url') ?: (($_SERVER['REQUEST_SCHEME'] ?? 'https') . '://' . ($_SERVER['HTTP_HOST'] ?? 'journeymastersltd.com')), '/');
        $urls  = ['/', '/about', '/services', '/destinations', '/blog', '/contact'];
        foreach (Content::services() as $s)     { $urls[] = '/services/' . $s['slug']; }
        foreach (Content::destinations() as $d) { $urls[] = '/destinations/' . $d['slug']; }
        foreach (Content::posts() as $p)        { $urls[] = '/blog/' . $p['slug']; }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            echo "  <url><loc>{$base}{$u}</loc><changefreq>weekly</changefreq></url>\n";
        }
        echo '</urlset>';
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        $base = rtrim(config('app.url') ?: (($_SERVER['REQUEST_SCHEME'] ?? 'https') . '://' . ($_SERVER['HTTP_HOST'] ?? 'journeymastersltd.com')), '/');
        echo "User-agent: *\nAllow: /\n\nSitemap: {$base}/sitemap.xml\n";
    }
}
