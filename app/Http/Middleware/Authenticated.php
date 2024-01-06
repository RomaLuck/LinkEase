<?php

namespace Http\Middleware;

class Authenticated
{
    public function handle(): void
    {
        if (!$_SESSION['user']) {
            header('location: /');
            exit();
        }
    }
}