<?php

namespace Src\Controllers;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Session\Session;

class Controller
{
    protected function render($path, $attributes = []): void
    {
        extract($attributes);

        require "views/$path";
    }

    #[NoReturn]
    protected function redirect($path, $messages = []): void
    {
        foreach ($messages as $messageKey => $message) {
            (new Session())->getFlashBag()->add($messageKey, $message);
        }

        header('location: ' . $path);
        exit();
    }
}