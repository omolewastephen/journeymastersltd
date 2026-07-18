<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Tiny, dependency-free router with named URL parameters, e.g. /services/{slug}.
 * Actions are "Controller@method" strings resolved under App\Controllers.
 */
final class Router
{
    /** @var array<string, array<string, string|callable>> */
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $uri, string|callable $action): void
    {
        $this->add('GET', $uri, $action);
    }

    public function post(string $uri, string|callable $action): void
    {
        $this->add('POST', $uri, $action);
    }

    private function add(string $method, string $uri, string|callable $action): void
    {
        $uri = '/' . trim($uri, '/');
        $this->routes[$method][$uri === '' ? '/' : $uri] = $action;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method() === 'POST' ? 'POST' : 'GET';
        $path   = $request->path();

        foreach ($this->routes[$method] as $route => $action) {
            $pattern = $this->compile($route);
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->run($action, array_values($params));
                return;
            }
        }

        // Nothing matched.
        (new Controller())->renderError(404);
    }

    private function compile(string $route): string
    {
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $route);
        return '#^' . $regex . '$#';
    }

    private function run(string|callable $action, array $params): void
    {
        if (is_callable($action)) {
            $action(...$params);
            return;
        }

        [$controller, $method] = explode('@', $action);
        $class = 'App\\Controllers\\' . $controller;

        if (!class_exists($class) || !method_exists($class, $method)) {
            (new Controller())->renderError(404);
            return;
        }

        (new $class())->{$method}(...$params);
    }
}
