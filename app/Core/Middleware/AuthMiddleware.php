<?php

namespace Core\Middleware;

use Core\Session;

class AuthMiddleware implements AuthMiddlewareInterface
{
    public function handle(): void
    {
        if (!Session::has('user')) {
            header('location: /');
            exit();
        }
    }
}