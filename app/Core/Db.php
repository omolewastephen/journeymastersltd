<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Small query helper over the PDO singleton. Table names & ORDER clauses are
 * always literals from our own code (never user input); values are bound.
 */
final class Db
{
    public static function pdo(): ?PDO
    {
        return Database::connection();
    }

    public static function driver(): string
    {
        $pdo = self::pdo();
        return $pdo ? (string) $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) : 'none';
    }

    public static function all(string $table, string $order = 'id ASC'): array
    {
        $pdo = self::pdo();
        return $pdo ? $pdo->query("SELECT * FROM {$table} ORDER BY {$order}")->fetchAll() : [];
    }

    public static function find(string $table, int $id): ?array
    {
        $pdo = self::pdo();
        if (!$pdo) {
            return null;
        }
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBy(string $table, string $column, mixed $value): ?array
    {
        $pdo = self::pdo();
        if (!$pdo) {
            return null;
        }
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :v LIMIT 1");
        $stmt->execute(['v' => $value]);
        return $stmt->fetch() ?: null;
    }

    public static function count(string $table, string $where = '1'): int
    {
        $pdo = self::pdo();
        return $pdo ? (int) $pdo->query("SELECT COUNT(*) FROM {$table} WHERE {$where}")->fetchColumn() : 0;
    }

    public static function insert(string $table, array $data): int
    {
        $pdo  = self::pdo();
        if (!$pdo) {
            return 0;
        }
        $cols = array_keys($data);
        $ph   = array_map(fn ($c) => ':' . $c, $cols);
        $sql  = "INSERT INTO {$table} (" . implode(',', $cols) . ') VALUES (' . implode(',', $ph) . ')';
        $pdo->prepare($sql)->execute($data);
        return (int) $pdo->lastInsertId();
    }

    public static function update(string $table, int $id, array $data): void
    {
        $pdo = self::pdo();
        if (!$pdo) {
            return;
        }
        $set = implode(', ', array_map(fn ($c) => "{$c} = :{$c}", array_keys($data)));
        $data['__id'] = $id;
        $pdo->prepare("UPDATE {$table} SET {$set} WHERE id = :__id")->execute($data);
    }

    public static function delete(string $table, int $id): void
    {
        $pdo = self::pdo();
        if ($pdo) {
            $pdo->prepare("DELETE FROM {$table} WHERE id = :id")->execute(['id' => $id]);
        }
    }

    public static function exec(string $sql): void
    {
        $pdo = self::pdo();
        if ($pdo) {
            $pdo->exec($sql);
        }
    }
}
