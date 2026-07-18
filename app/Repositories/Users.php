<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class Users
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return null;
        }
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return null;
        }
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function touchLogin(int $id): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return;
        }
        $stmt = $pdo->prepare('UPDATE users SET last_login = :ts WHERE id = :id');
        $stmt->execute(['ts' => date('Y-m-d H:i:s'), 'id' => $id]);
    }

    public static function updatePassword(int $id, string $hash): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return;
        }
        $stmt = $pdo->prepare('UPDATE users SET password = :pw WHERE id = :id');
        $stmt->execute(['pw' => $hash, 'id' => $id]);
    }
}
