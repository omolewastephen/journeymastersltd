<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Db;

/**
 * Public-site content. Reads from the database when the content tables are
 * populated; otherwise falls back to app/Data/content.php so the site never
 * shows empty sections before the seeder has run.
 */
final class Content
{
    private static ?array $file = null;
    private static array $cache = [];

    private static function file(): array
    {
        return self::$file ??= require BASE_PATH . '/app/Data/content.php';
    }

    private static function published(string $table, string $order): array
    {
        $pdo = Db::pdo();
        if ($pdo === null) {
            return [];
        }
        try {
            return $pdo->query("SELECT * FROM {$table} WHERE is_published = 1 ORDER BY {$order}")->fetchAll();
        } catch (\Throwable) {
            return []; // table not migrated yet → fall back
        }
    }

    private static function dec(mixed $v): array
    {
        if (is_array($v)) {
            return $v;
        }
        $out = json_decode((string) $v, true);
        return is_array($out) ? $out : [];
    }

    /* ------------------------------------------------------------- Services */
    public static function services(): array
    {
        return self::$cache['services'] ??= (function () {
            $rows = self::published('services', 'sort_order ASC, id ASC');
            if ($rows === []) {
                return self::file()['services'];
            }
            return array_map(fn ($r) => [
                'slug' => $r['slug'], 'title' => $r['title'], 'tagline' => $r['tagline'],
                'summary' => $r['summary'], 'overview' => self::dec($r['overview']),
                'icon' => $r['icon'], 'image' => media($r['image']),
                'benefits' => self::dec($r['benefits']), 'requirements' => self::dec($r['requirements']),
                'timeline' => self::dec($r['timeline']), 'faqs' => self::dec($r['faqs']),
            ], $rows);
        })();
    }

    public static function service(string $slug): ?array
    {
        foreach (self::services() as $s) {
            if ($s['slug'] === $slug) {
                return $s;
            }
        }
        return null;
    }

    public static function servicesBySlugs(array $slugs): array
    {
        $out = [];
        foreach ($slugs as $slug) {
            if ($s = self::service($slug)) {
                $out[] = $s;
            }
        }
        return $out;
    }

    /* --------------------------------------------------------- Destinations */
    public static function destinations(): array
    {
        return self::$cache['destinations'] ??= (function () {
            $rows = self::published('destinations', 'sort_order ASC, id ASC');
            if ($rows === []) {
                return self::file()['destinations'];
            }
            return array_map(fn ($r) => [
                'slug' => $r['slug'], 'country' => $r['country'], 'title' => $r['title'],
                'intro' => $r['intro'], 'duration' => $r['duration'], 'image' => media($r['image']),
                'highlights' => self::dec($r['highlights']), 'requirements' => self::dec($r['requirements']),
                'services' => self::dec($r['related_services']), 'gallery' => array_map('media', self::dec($r['gallery'])),
            ], $rows);
        })();
    }

    public static function destination(string $slug): ?array
    {
        foreach (self::destinations() as $d) {
            if ($d['slug'] === $slug) {
                return $d;
            }
        }
        return null;
    }

    /* ---------------------------------------------------------------- Posts */
    public static function posts(): array
    {
        return self::$cache['posts'] ??= (function () {
            $rows = self::published('posts', 'published_at DESC, id DESC');
            if ($rows === []) {
                return self::file()['posts'];
            }
            return array_map(fn ($r) => [
                'slug' => $r['slug'], 'title' => $r['title'], 'category' => $r['category'],
                'read' => $r['read_time'], 'date' => $r['published_at'] ?: $r['created_at'],
                'image' => media($r['image']), 'excerpt' => $r['excerpt'], 'body' => $r['body'],
            ], $rows);
        })();
    }

    public static function post(string $slug): ?array
    {
        foreach (self::posts() as $p) {
            if ($p['slug'] === $slug) {
                return $p;
            }
        }
        return null;
    }

    public static function relatedPosts(string $excludeSlug, int $limit = 2): array
    {
        return array_slice(
            array_values(array_filter(self::posts(), fn ($p) => $p['slug'] !== $excludeSlug)),
            0,
            $limit
        );
    }

    /* --------------------------------------------------------- Testimonials */
    public static function testimonials(): array
    {
        return self::$cache['testimonials'] ??= (function () {
            $rows = self::published('testimonials', 'sort_order ASC, id ASC');
            if ($rows === []) {
                return self::file()['testimonials'];
            }
            return array_map(fn ($r) => [
                'name' => $r['name'], 'role' => $r['role'], 'avatar' => media($r['avatar']), 'quote' => $r['quote'],
            ], $rows);
        })();
    }

    /* ------------------------------------------------------------------ FAQ */
    public static function faqs(): array
    {
        return self::$cache['faqs'] ??= (function () {
            $rows = self::published('faqs', 'sort_order ASC, id ASC');
            if ($rows === []) {
                return self::file()['faqs'];
            }
            return array_map(fn ($r) => ['q' => $r['question'], 'a' => $r['answer']], $rows);
        })();
    }

    /* ---------------------------------------------------- Static (array) --- */
    public static function stats(): array
    {
        return self::file()['stats'];
    }

    public static function process(): array
    {
        return self::file()['process'];
    }
}
