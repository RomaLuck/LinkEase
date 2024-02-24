<?php

namespace Src\Controllers;

use eftec\bladeone\BladeOne;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Session\Session;

class Controller
{
    protected function render($path, $attributes = []): void
    {
        $views = __DIR__ . '/../../views';
        $cache = __DIR__ . '/../../var/cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $blade->pipeEnable = true;

        echo $blade->run($path, $attributes);
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