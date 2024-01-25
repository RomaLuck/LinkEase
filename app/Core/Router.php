<?php

namespace Core;

use Core\Middleware\AuthMiddleware;

class Router
{
    protected array $routes = [];

    public function addRoute(string $method, string $path, mixed $controller): static
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
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
        $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                AuthMiddleware::resolve($route['middleware']);
                call_user_func($route['controller'], new Container());
                return;
            }
        }
        abort(Response::NOT_FOUND);
    }
}