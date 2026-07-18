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

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            // SQLite dev connection (production stays MySQL) — set DB_CONNECTION=sqlite.
            if (config('db.connection') === 'sqlite') {
                self::$instance = new PDO('sqlite:' . config('db.sqlite_path'), null, null, $options);
                self::$instance->exec('PRAGMA foreign_keys = ON');
                return self::$instance;
            }

            $c   = config('db');
            $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}";
            self::$instance = new PDO($dsn, $c['user'], $c['pass'], $options);
        } catch (PDOException $e) {
            if (config('app.debug')) {
                throw $e;
            }
            return null;
        }

        return self::$instance;
    }
}
