<?php

namespace Http\Controllers;

use JetBrains\PhpStorm\NoReturn;

class Controller
{
    protected function render($path, $attributes = []): void
    {
        extract($attributes);

        require "views/$path";
    }

    #[NoReturn]
    protected function redirect($path, $attributes = []): void
    {
        foreach ($attributes as $attribute) {
            $_SESSION['_flash']['errors'] = $attribute;
        }

        header('location: ' . $path);
        exit();
    }
}