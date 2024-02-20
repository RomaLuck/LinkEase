<?php

namespace Src\Middleware;


use Symfony\Component\HttpFoundation\Session\Session;

class AuthMiddleware implements AuthMiddlewareInterface
{
    public function handle(): void
    {
        if (!(new Session())->has('user')) {
            header('location: /');
            exit();
        }
    }
}