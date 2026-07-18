<?php
/**
 * Application bootstrap — the single entry point wired to public/index.php.
 * Sets up autoloading, environment, error handling, session and routing.
 */

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

/* --- Minimal .env loader (no Composer dependency required) ---------------- */
(function () {
    $file = BASE_PATH . '/.env';
    if (!is_file($file)) {
        return;
    }
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
})();

/* --- env() helper needed by config ---------------------------------------- */
function env(string $key, mixed $default = null): mixed
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

/* --- PSR-4 autoloader: App\  ->  app/ ------------------------------------- */
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = BASE_PATH . '/app/' . $relative . '.php';
    if (is_file($file)) {
        require $file;
    }
});

/* --- Composer autoload (optional: PHPMailer etc.) ------------------------- */
if (is_file(BASE_PATH . '/vendor/autoload.php')) {
    require BASE_PATH . '/vendor/autoload.php';
}

/* --- Load config & helpers ------------------------------------------------ */
$GLOBALS['config'] = require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/Helpers/functions.php';

/* --- Environment ---------------------------------------------------------- */
date_default_timezone_set(config('app.timezone', 'Africa/Lagos'));

if (config('app.debug')) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('display_errors', '0');
}

/* --- Base URL detection (works at domain root OR in a subfolder) ---------- */
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = rtrim($scriptDir, '/');
define('BASE_URL', $scriptDir === '/' ? '' : $scriptDir);

/* --- Security headers ----------------------------------------------------- */
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

/* --- Session -------------------------------------------------------------- */
\App\Core\Session::start();

/* --- Route ---------------------------------------------------------------- */
$router  = new \App\Core\Router();
$request = new \App\Core\Request();
require BASE_PATH . '/config/routes.php';

try {
    $router->dispatch($request);
} catch (\Throwable $e) {
    if (config('app.debug')) {
        http_response_code(500);
        echo '<pre style="padding:2rem;font:14px/1.6 monospace">'
            . e($e->getMessage()) . "\n\n" . e($e->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        (new \App\Core\Controller())->renderError(500);
    }
}
