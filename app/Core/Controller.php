<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base controller. Provides view rendering, redirects and error pages.
 */
class Controller
{
    protected function view(string $view, array $data = [], ?string $layout = 'layouts/app'): void
    {
        echo View::render($view, $data, $layout);
    }

    protected function redirect(string $to): never
    {
        header('Location: ' . url($to));
        exit;
    }

    protected function back(): never
    {
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }

    protected function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function renderError(int $code, string $message = ''): void
    {
        http_response_code($code);
        $view = is_file(BASE_PATH . "/app/Views/errors/{$code}.php") ? "errors/{$code}" : 'errors/404';
        echo View::render($view, [
            'title'   => $code === 404 ? 'Page not found' : 'Something went wrong',
            'code'    => $code,
            'message' => $message,
        ]);
    }
}
