<?php
/**
 * Content seeder CLI.  Usage:  php database/seed.php
 * Migrates the content tables and imports app/Data/content.php into the DB.
 * (The admin also exposes this via a button — no shell access required.)
 */

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

// Minimal .env load (only if a var isn't already in the environment).
foreach (@file(BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
        continue;
    }
    [$k, $v] = array_map('trim', explode('=', $line, 2));
    if (getenv($k) === false) {
        putenv($k . '=' . trim($v, "\"'"));
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $v = getenv($key);
        return $v === false ? $default : $v;
    }
}

spl_autoload_register(function (string $class): void {
    if (str_starts_with($class, 'App\\')) {
        $file = BASE_PATH . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
});

$GLOBALS['config'] = require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/Helpers/functions.php';

$result = \App\Support\ContentSeeder::run();
echo json_encode($result, JSON_PRETTY_PRINT) . "\n";
