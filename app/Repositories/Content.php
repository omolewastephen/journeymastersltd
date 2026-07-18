<?php

declare(strict_types=1);

namespace App\Repositories;

/**
 * Read access to site content. Currently backed by app/Data/content.php.
 * Swap the internals for PDO queries (App\Core\Database) once the DB is live —
 * the public method signatures stay identical, so views never change.
 */
final class Content
{
    private static ?array $data = null;

    private static function data(): array
    {
        return self::$data ??= require BASE_PATH . '/app/Data/content.php';
    }

    /** @return array<int, array> */
    public static function services(): array
    {
        return self::data()['services'];
    }

    public static function service(string $slug): ?array
    {
        foreach (self::services() as $service) {
            if ($service['slug'] === $slug) {
                return $service;
            }
        }
        return null;
    }

    /** @param array<int,string> $slugs */
    public static function servicesBySlugs(array $slugs): array
    {
        $out = [];
        foreach ($slugs as $slug) {
            if ($service = self::service($slug)) {
                $out[] = $service;
            }
        }
        return $out;
    }

    public static function destinations(): array
    {
        return self::data()['destinations'];
    }

    public static function destination(string $slug): ?array
    {
        foreach (self::destinations() as $destination) {
            if ($destination['slug'] === $slug) {
                return $destination;
            }
        }
        return null;
    }

    public static function posts(): array
    {
        return self::data()['posts'];
    }

    public static function post(string $slug): ?array
    {
        foreach (self::posts() as $post) {
            if ($post['slug'] === $slug) {
                return $post;
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

    public static function faqs(): array
    {
        return self::data()['faqs'];
    }

    public static function testimonials(): array
    {
        return self::data()['testimonials'];
    }

    public static function stats(): array
    {
        return self::data()['stats'];
    }

    public static function process(): array
    {
        return self::data()['process'];
    }
}
