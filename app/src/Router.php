<?php

namespace Src;

use Src\Middleware\AuthMiddlewareDetection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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
    public function matchRoute(): Response
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
                return call_user_func_array($controller, $parameters);
            }
        }
        return new RedirectResponse('/404');
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

    public function getRoutes(): array
    {
        return $this->routes;
    }
}