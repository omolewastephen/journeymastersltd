<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDOException;

final class Subscribers
{
    /** Insert, ignoring duplicates (cross-dialect: catch the UNIQUE violation). */
    public static function store(string $email, string $ip): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            $dir = BASE_PATH . '/storage';
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
            $path  = $dir . '/subscribers.json';
            $all   = is_file($path) ? (json_decode((string) file_get_contents($path), true) ?: []) : [];
            $all[] = ['email' => $email, 'ip' => $ip, 'created_at' => date('Y-m-d H:i:s')];
            file_put_contents($path, json_encode($all, JSON_PRETTY_PRINT), LOCK_EX);
            return;
        }
        try {
            $stmt = $pdo->prepare('INSERT INTO subscribers (email, ip_address, created_at) VALUES (:email, :ip, :ts)');
            $stmt->execute(['email' => $email, 'ip' => $ip, 'ts' => date('Y-m-d H:i:s')]);
        } catch (PDOException $e) {
            // Duplicate email (UNIQUE) — silently ignore; anything else re-throws.
            if (!str_contains($e->getMessage(), 'UNIQUE') && $e->getCode() !== '23000') {
                throw $e;
            }
        }
    }

    public static function all(): array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return [];
        }
        return $pdo->query('SELECT * FROM subscribers ORDER BY created_at DESC')->fetchAll();
    }

    public static function count(): int
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return 0;
        }
        return (int) $pdo->query('SELECT COUNT(*) FROM subscribers')->fetchColumn();
    }

    public static function delete(int $id): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return;
        }
        $pdo->prepare('DELETE FROM subscribers WHERE id = :id')->execute(['id' => $id]);
    }
}
