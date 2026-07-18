<?php
/**
 * Journey Masters Ltd — front controller.
 * Every request (that isn't a real static file) routes through here.
 */

// PHP built-in server: serve existing static assets directly.
if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

// Locate the application. Supports two deploy layouts:
//  1. public/ is the web root, app/ lives one level up (recommended, local dev).
//  2. Everything sits inside public_html together (flattened cPanel deploy).
$boot = dirname(__DIR__) . '/app/bootstrap.php';
if (!is_file($boot)) {
    $boot = __DIR__ . '/app/bootstrap.php';
}
require $boot;
