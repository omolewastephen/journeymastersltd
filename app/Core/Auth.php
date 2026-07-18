<?php

declare(strict_types=1);

namespace App\Core;

use App\Repositories\Users;

/**
 * Session-based authentication for the admin area.
 */
final class Auth
{
    private static ?array $cached = null;

    public static function attempt(string $email, string $password): bool
    {
        $user = Users::findByEmail($email);
        if ($user === null || (int) ($user['is_active'] ?? 1) !== 1) {
            return false;
        }
        if (!password_verify($password, (string) $user['password'])) {
            return false;
        }
        self::login($user);
        Users::touchLogin((int) $user['id']);
        return true;
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['auth_id'] = (int) $user['id'];
        self::$cached = $user;
    }

    public static function check(): bool
    {
        return !empty($_SESSION['auth_id']);
    }

    public static function id(): ?int
    {
        return isset($_SESSION['auth_id']) ? (int) $_SESSION['auth_id'] : null;
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return self::$cached ??= Users::find((int) self::id());
    }

    public static function logout(): void
    {
        self::$cached = null;
        unset($_SESSION['auth_id']);
        session_regenerate_id(true);
    }
}
