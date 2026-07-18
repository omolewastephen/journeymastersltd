<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Parses admin textarea input into structured arrays, and back for editing.
 */
final class Fields
{
    /** One item per line → ["a","b"]. */
    public static function lines(string $text): array
    {
        $out = [];
        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = trim($line);
            if ($line !== '') {
                $out[] = $line;
            }
        }
        return $out;
    }

    public static function linesToText(array $items): string
    {
        return implode("\n", $items);
    }

    /** "Left | Right" per line → [[$ka=>left, $kb=>right], …]. */
    public static function pairs(string $text, string $ka, string $kb): array
    {
        $out = [];
        foreach (self::lines($text) as $line) {
            $parts = array_map('trim', explode('|', $line, 2));
            $out[] = [$ka => $parts[0], $kb => $parts[1] ?? ''];
        }
        return $out;
    }

    public static function pairsToText(array $items, string $ka, string $kb): string
    {
        $lines = [];
        foreach ($items as $it) {
            $lines[] = ($it[$ka] ?? '') . ' | ' . ($it[$kb] ?? '');
        }
        return implode("\n", $lines);
    }
}
