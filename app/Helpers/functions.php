<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;

/**
 * Global template & app helpers.
 */

if (!function_exists('config')) {
    /** Dot-notation config access: config('business.phone'). */
    function config(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = $GLOBALS['config'] ?? [];
        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        return $value;
    }
}

if (!function_exists('biz')) {
    /** Business-detail shortcut: biz('whatsapp'). */
    function biz(string $key, mixed $default = null): mixed
    {
        return config('business.' . $key, $default);
    }
}

if (!function_exists('e')) {
    /** HTML-escape output (XSS protection). */
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('url')) {
    /** Build an app URL, honouring the detected base path. */
    function url(string $path = '/'): string
    {
        if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, 'mailto:') || str_starts_with($path, 'tel:')) {
            return $path;
        }
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    /** URL for a file under public/assets. */
    function asset(string $path): string
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return Csrf::field();
    }
}

if (!function_exists('old')) {
    function old(string $key, string $default = ''): string
    {
        return e((string) Session::old($key, $default));
    }
}

if (!function_exists('current_path')) {
    function current_path(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        if (BASE_URL !== '' && str_starts_with($uri, BASE_URL)) {
            $uri = substr($uri, strlen(BASE_URL));
        }
        return '/' . trim($uri, '/');
    }
}

if (!function_exists('is_active')) {
    /** aria-current helper for nav links. */
    function is_active(string $path, bool $exact = false): bool
    {
        $current = current_path();
        $path = '/' . trim($path, '/');
        return $exact ? $current === $path : str_starts_with($current, $path) && $path !== '/';
    }
}

if (!function_exists('nav_current')) {
    function nav_current(string $path): string
    {
        return is_active($path) ? ' aria-current="page"' : '';
    }
}

if (!function_exists('excerpt')) {
    function excerpt(string $text, int $words = 24): string
    {
        $parts = preg_split('/\s+/', trim($text));
        if (count($parts) <= $words) {
            return $text;
        }
        return implode(' ', array_slice($parts, 0, $words)) . '…';
    }
}

if (!function_exists('site_base')) {
    /** Absolute site base URL. Uses APP_URL when set to a real host, else derives
     *  it from the request (with correct HTTPS detection behind cPanel proxies). */
    function site_base(): string
    {
        $configured = (string) config('app.url');
        if ($configured !== '' && !str_contains($configured, 'localhost') && !str_contains($configured, '127.0.0.1')) {
            return rtrim($configured, '/');
        }
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
            || (($_SERVER['SERVER_PORT'] ?? '') == 443);
        $host = $_SERVER['HTTP_HOST'] ?? 'journeymastersltd.ng';
        return ($https ? 'https' : 'http') . '://' . $host;
    }
}

if (!function_exists('canonical_url')) {
    function canonical_url(): string
    {
        return site_base() . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    }
}

if (!function_exists('pub_pill')) {
    function pub_pill(mixed $published): string
    {
        return ((int) $published) === 1
            ? '<span class="pill pill--ok">Published</span>'
            : '<span class="pill pill--muted">Draft</span>';
    }
}

if (!function_exists('fv')) {
    /** Escaped form value for admin edit forms (prefills from the record). */
    function fv(?array $item, string $key, string $default = ''): string
    {
        return e((string) ($item[$key] ?? $default));
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
        return trim($text, '-') ?: 'item';
    }
}

if (!function_exists('media')) {
    /** Resolve a stored image reference (full URL, root-relative, or an uploads/ path). */
    function media(?string $path): string
    {
        $path = (string) $path;
        if ($path === '') {
            return '';
        }
        if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, '/')) {
            return $path;
        }
        return url($path);
    }
}

if (!function_exists('whatsapp_url')) {
    /** Prefill a WhatsApp message where the click-to-chat link supports it. */
    function whatsapp_url(string $text = ''): string
    {
        return biz('whatsapp');
    }
}
