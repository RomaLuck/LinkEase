<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Src\Router;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testAddRoute(): void
    {
        $this->router->addRoute('GET', '/test', 'TestController');
        $this->assertNotEmpty($this->router->getRoutes());
    }

    public function testMiddleware(): void
    {
        $this->router->addRoute('GET', '/test', 'TestController')->middleware('auth');
        $routes = $this->router->getRoutes();
        $this->assertEquals('auth', end($routes)['middleware']);
    }
}