<?php

namespace Src\Middleware;

use Src\Session;

class GuestMiddleware implements AuthMiddlewareInterface
{
    public function handle(): void
    {
        if (Session::has('user')) {
            header('location: /');
            exit();
        }
    }
}