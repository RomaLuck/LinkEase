<?php

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Session\Session;

class GuestMiddleware implements AuthMiddlewareInterface
{
    public function handle(): void
    {
        if ((new Session())->has('user')) {
            header('location: /');
            exit();
        }
    }
}