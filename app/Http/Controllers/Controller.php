<?php

namespace Http\Controllers;

use Core\Session;
use JetBrains\PhpStorm\NoReturn;

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
            Session::flash($messageKey, $message);
        }

        header('location: ' . $path);
        exit();
    }
}