<?php

namespace Http\Middleware;

class Guest
{
    public function handle(): void
    {
        if (array_key_exists('user', $_SESSION)) {
            header('location: /');
            exit();
        }
    }
}