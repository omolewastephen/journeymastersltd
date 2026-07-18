<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * PDO singleton. The app runs fully on array-backed content until a database
 * is configured (DB_ENABLED=true), so connection failures degrade gracefully.
 */
final class Database
{
    private static ?PDO $instance = null;

    public static function connection(): ?PDO
    {
        if (!config('db.enabled')) {
            return null;
        }
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $c   = config('db');
        $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}";

        try {
            self::$instance = new PDO($dsn, $c['user'], $c['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            if (config('app.debug')) {
                throw $e;
            }
            return null;
        }

        return self::$instance;
    }
}
