<?php

namespace Core;

use Core\Middleware\AuthMiddleware;

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $url, mixed $controller): static
    {
        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'controller' => $controller,
            'middleware' => null
        ];

        return $this;
    }

    public function middleware($key): static
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function matchRoute(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        foreach ($this->routes as $route) {
            if ($route['url'] === $url && $route['method'] === $method) {
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $route['url']);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    AuthMiddleware::resolve($route['middleware']);
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $route['controller'](...$params);
                    return;
                }
            }
        }
        abort(404);
    }
}