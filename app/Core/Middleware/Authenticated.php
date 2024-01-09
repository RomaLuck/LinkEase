<?php

namespace Core\Middleware;

class Authenticated
{
    public function handle(): void
    {
        if (!array_key_exists('user', $_SESSION)) {
            header('location: /');
            exit();
        }
    }
}