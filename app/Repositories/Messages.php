<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

/**
 * Stores contact-form enquiries. Uses MySQL when DB_ENABLED=true, otherwise
 * appends to storage/messages.json so nothing is lost before the DB is live.
 */
final class Messages
{
    public static function store(array $data): void
    {
        $row = [
            'name'       => (string) ($data['name'] ?? ''),
            'email'      => (string) ($data['email'] ?? ''),
            'phone'      => (string) ($data['phone'] ?? ''),
            'service'    => (string) ($data['service'] ?? ''),
            'message'    => (string) ($data['message'] ?? ''),
            'ip'         => (string) ($data['ip'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $pdo = Database::connection();
        if ($pdo !== null) {
            $stmt = $pdo->prepare(
                'INSERT INTO messages (name, email, phone, service, message, ip_address, created_at)
                 VALUES (:name, :email, :phone, :service, :message, :ip, :created_at)'
            );
            $stmt->execute($row);
            return;
        }

        self::appendFile('messages.json', $row);
    }

    private static function appendFile(string $file, array $row): void
    {
        $dir = BASE_PATH . '/storage';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $path = $dir . '/' . $file;
        $all  = is_file($path) ? (json_decode((string) file_get_contents($path), true) ?: []) : [];
        $all[] = $row;
        file_put_contents($path, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    public static function appendSubscriber(array $row): void
    {
        self::appendFile('subscribers.json', $row);
    }
}
