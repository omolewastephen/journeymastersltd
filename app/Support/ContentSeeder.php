<?php

declare(strict_types=1);

namespace App\Support;

use App\Core\Db;

/**
 * Migrates the content tables to the JSON-column design and imports the starter
 * content from app/Data/content.php. Driver-aware (MySQL on prod, SQLite in dev).
 * Safe to re-run — it drops and recreates only the CONTENT tables (users,
 * messages, subscribers, settings are untouched).
 */
final class ContentSeeder
{
    public static function run(): array
    {
        $pdo = Db::pdo();
        if ($pdo === null) {
            return ['ok' => false, 'error' => 'No database connection.'];
        }

        $sqlite = Db::driver() === 'sqlite';
        $id     = $sqlite ? 'id INTEGER PRIMARY KEY AUTOINCREMENT' : 'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
        $suffix = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';

        // Drop legacy + content tables, then recreate with the new shape.
        // FK checks off so old foreign keys (e.g. posts→post_categories) don't
        // block the drops; child tables are also listed before their parents.
        Db::exec($sqlite ? 'PRAGMA foreign_keys = OFF' : 'SET FOREIGN_KEY_CHECKS = 0');
        foreach (['service_features', 'galleries', 'posts', 'post_categories', 'services', 'destinations', 'testimonials', 'faqs'] as $t) {
            Db::exec("DROP TABLE IF EXISTS {$t}");
        }
        Db::exec($sqlite ? 'PRAGMA foreign_keys = ON' : 'SET FOREIGN_KEY_CHECKS = 1');

        $tables = [
            'services'     => "slug VARCHAR(160) NOT NULL UNIQUE, title VARCHAR(160), tagline VARCHAR(255), summary TEXT, overview TEXT, icon TEXT, image VARCHAR(255), benefits TEXT, requirements TEXT, timeline TEXT, faqs TEXT, sort_order INT DEFAULT 0, is_published TINYINT DEFAULT 1, created_at VARCHAR(25), updated_at VARCHAR(25)",
            'destinations' => "slug VARCHAR(160) NOT NULL UNIQUE, country VARCHAR(120), title VARCHAR(200), intro TEXT, duration VARCHAR(120), image VARCHAR(255), highlights TEXT, requirements TEXT, related_services TEXT, gallery TEXT, sort_order INT DEFAULT 0, is_published TINYINT DEFAULT 1, created_at VARCHAR(25), updated_at VARCHAR(25)",
            'posts'        => "slug VARCHAR(190) NOT NULL UNIQUE, title VARCHAR(220), category VARCHAR(120), excerpt TEXT, body TEXT, image VARCHAR(255), read_time VARCHAR(20), is_published TINYINT DEFAULT 1, published_at VARCHAR(25), created_at VARCHAR(25), updated_at VARCHAR(25)",
            'testimonials' => "name VARCHAR(120), role VARCHAR(160), avatar VARCHAR(255), quote TEXT, rating INT DEFAULT 5, sort_order INT DEFAULT 0, is_published TINYINT DEFAULT 1",
            'faqs'         => "question VARCHAR(255), answer TEXT, sort_order INT DEFAULT 0, is_published TINYINT DEFAULT 1",
        ];
        foreach ($tables as $name => $cols) {
            Db::exec("CREATE TABLE {$name} ({$id}, {$cols}){$suffix}");
        }

        $data = require BASE_PATH . '/app/Data/content.php';
        $now  = date('Y-m-d H:i:s');
        $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        foreach (array_values($data['services']) as $i => $s) {
            Db::insert('services', [
                'slug' => $s['slug'], 'title' => $s['title'], 'tagline' => $s['tagline'] ?? '',
                'summary' => $s['summary'] ?? '', 'overview' => $json($s['overview'] ?? []),
                'icon' => $s['icon'] ?? '', 'image' => $s['image'] ?? '',
                'benefits' => $json($s['benefits'] ?? []), 'requirements' => $json($s['requirements'] ?? []),
                'timeline' => $json($s['timeline'] ?? []), 'faqs' => $json($s['faqs'] ?? []),
                'sort_order' => $i, 'is_published' => 1, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        foreach (array_values($data['destinations']) as $i => $d) {
            Db::insert('destinations', [
                'slug' => $d['slug'], 'country' => $d['country'], 'title' => $d['title'],
                'intro' => $d['intro'] ?? '', 'duration' => $d['duration'] ?? '', 'image' => $d['image'] ?? '',
                'highlights' => $json($d['highlights'] ?? []), 'requirements' => $json($d['requirements'] ?? []),
                'related_services' => $json($d['services'] ?? []), 'gallery' => $json($d['gallery'] ?? []),
                'sort_order' => $i, 'is_published' => 1, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        foreach (array_values($data['posts']) as $p) {
            $body = is_array($p['body']) ? implode('', array_map(fn ($x) => '<p>' . $x . '</p>', $p['body'])) : (string) $p['body'];
            Db::insert('posts', [
                'slug' => $p['slug'], 'title' => $p['title'], 'category' => $p['category'] ?? '',
                'excerpt' => $p['excerpt'] ?? '', 'body' => $body, 'image' => $p['image'] ?? '',
                'read_time' => $p['read'] ?? '', 'is_published' => 1,
                'published_at' => ($p['date'] ?? date('Y-m-d')) . ' 09:00:00', 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        foreach (array_values($data['testimonials']) as $i => $t) {
            Db::insert('testimonials', [
                'name' => $t['name'], 'role' => $t['role'] ?? '', 'avatar' => $t['avatar'] ?? '',
                'quote' => $t['quote'], 'rating' => 5, 'sort_order' => $i, 'is_published' => 1,
            ]);
        }

        foreach (array_values($data['faqs']) as $i => $f) {
            Db::insert('faqs', ['question' => $f['q'], 'answer' => $f['a'], 'sort_order' => $i, 'is_published' => 1]);
        }

        return [
            'ok'           => true,
            'services'     => Db::count('services'),
            'destinations' => Db::count('destinations'),
            'posts'        => Db::count('posts'),
            'testimonials' => Db::count('testimonials'),
            'faqs'         => Db::count('faqs'),
        ];
    }
}
