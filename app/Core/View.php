<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Server-side templating: renders a PHP view, optionally wrapped in a layout.
 * Views live in app/Views and receive $data as extracted local variables.
 */
final class View
{
    public static function render(string $view, array $data = [], ?string $layout = 'layouts/app'): string
    {
        $content = self::renderFile($view, $data);

        if ($layout !== null) {
            $data['content'] = $content;
            return self::renderFile($layout, $data);
        }

        return $content;
    }

    public static function renderFile(string $view, array $data = []): string
    {
        $file = BASE_PATH . '/app/Views/' . $view . '.php';
        if (!is_file($file)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return (string) ob_get_clean();
    }
}
