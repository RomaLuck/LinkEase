<?php

namespace Http\Middleware;

class Guest
{
    public function handle(): void
    {
        if ($_SESSION['user']) {
            header('location: /');
            exit();
        }
    }
}