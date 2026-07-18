<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

/**
 * Contact-form enquiries. Writes to MySQL when connected, else appends to
 * storage/messages.json. Admin read methods query the DB (admin always has one).
 */
final class Messages
{
    public static function store(array $data): void
    {
        $row = [
            'name'    => (string) ($data['name'] ?? ''),
            'email'   => (string) ($data['email'] ?? ''),
            'phone'   => (string) ($data['phone'] ?? ''),
            'service' => (string) ($data['service'] ?? ''),
            'message' => (string) ($data['message'] ?? ''),
            'ip'      => (string) ($data['ip'] ?? ''),
        ];

        $pdo = Database::connection();
        if ($pdo !== null) {
            $stmt = $pdo->prepare(
                'INSERT INTO messages (name, email, phone, service, message, ip_address, created_at)
                 VALUES (:name, :email, :phone, :service, :message, :ip, :ts)'
            );
            $stmt->execute($row + ['ts' => date('Y-m-d H:i:s')]);
            return;
        }

        $row['created_at'] = date('Y-m-d H:i:s');
        self::appendFile('messages.json', $row);
    }

    /** @return array<int,array> */
    public static function paginate(int $page, int $perPage = 15): array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return [];
        }
        $offset = max(0, ($page - 1) * $perPage);
        $stmt = $pdo->prepare('SELECT * FROM messages ORDER BY created_at DESC LIMIT :lim OFFSET :off');
        $stmt->bindValue(':lim', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return null;
        }
        $stmt = $pdo->prepare('SELECT * FROM messages WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function markRead(int $id): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return;
        }
        $pdo->prepare('UPDATE messages SET is_read = 1 WHERE id = :id')->execute(['id' => $id]);
    }

    public static function delete(int $id): void
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return;
        }
        $pdo->prepare('DELETE FROM messages WHERE id = :id')->execute(['id' => $id]);
    }

    public static function count(): int
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return 0;
        }
        return (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
    }

    public static function unreadCount(): int
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return 0;
        }
        return (int) $pdo->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();
    }

    public static function recent(int $limit = 5): array
    {
        $pdo = Database::connection();
        if ($pdo === null) {
            return [];
        }
        $stmt = $pdo->prepare('SELECT * FROM messages ORDER BY created_at DESC LIMIT :lim');
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private static function appendFile(string $file, array $row): void
    {
        $dir = BASE_PATH . '/storage';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $path  = $dir . '/' . $file;
        $all   = is_file($path) ? (json_decode((string) file_get_contents($path), true) ?: []) : [];
        $all[] = $row;
        file_put_contents($path, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
