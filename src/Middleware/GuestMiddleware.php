<?php

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class GuestMiddleware implements AuthMiddlewareInterface
{
    public function handle(): ?Response
    {
        if ((new Session())->has('user')) {
            return new RedirectResponse('/');
        }
        return null;
    }
}