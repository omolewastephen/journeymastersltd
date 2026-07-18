<?php

declare(strict_types=1);

namespace App\Core;

use finfo;

/**
 * Secure image uploads. Validates the real MIME type (not the extension),
 * enforces a size cap, and stores under the web root's /uploads with a
 * random name. Returns a web path like "uploads/content/ab12cd.jpg".
 */
final class Upload
{
    private const MAX_BYTES = 4 * 1024 * 1024; // 4 MB
    private const ALLOWED   = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/avif' => 'avif',
    ];

    /** @return array{path?:string,error?:string} */
    public static function image(array $file, string $subdir = 'content'): array
    {
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return []; // nothing uploaded — not an error
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Upload failed. Please try again.'];
        }
        if (($file['size'] ?? 0) > self::MAX_BYTES) {
            return ['error' => 'Image must be 4 MB or smaller.'];
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::ALLOWED[$mime])) {
            return ['error' => 'Only JPG, PNG, WEBP, GIF or AVIF images are allowed.'];
        }

        $root = defined('WEBROOT') ? WEBROOT : BASE_PATH . '/public';
        $dir  = $root . '/uploads/' . $subdir;
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return ['error' => 'Could not create the upload directory.'];
        }

        $name = bin2hex(random_bytes(8)) . '.' . self::ALLOWED[$mime];
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)
            && !(PHP_SAPI === 'cli-server' && rename($file['tmp_name'], $dir . '/' . $name))) {
            return ['error' => 'Could not save the uploaded file.'];
        }

        return ['path' => 'uploads/' . $subdir . '/' . $name];
    }
}
