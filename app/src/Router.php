<?php

namespace Src;

use Src\Middleware\AuthMiddlewareDetection;
use JetBrains\PhpStorm\NoReturn;

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
        $container = new Container();

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                if ($route['middleware'] !== null) {
                    $middleware = AuthMiddlewareDetection::from($route['middleware'])->detect();
                    $middleware->handle();
                }
                $controller = new $route['controller']();
                $parameters = $this->resolveParameters($controller, $container);
                call_user_func_array($controller, $parameters)->send();
                return;
            }
        }
        $this->abort(Response::NOT_FOUND);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function resolveParameters(callable $controller, Container $container): array
    {
        $reflection = new \ReflectionMethod($controller, '__invoke');
        $parameters = $reflection->getParameters();
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependenceClass = (string)$parameter->getType();
            $dependencies[] = $container->get($dependenceClass);
        }

        return $dependencies;
    }

    #[NoReturn]
    public function abort($code): void
    {
        http_response_code($code);

        require("Http/$code.php");
        die();
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}