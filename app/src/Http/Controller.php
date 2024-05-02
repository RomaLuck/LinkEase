<?php

namespace Src\Http;

use eftec\bladeone\BladeOne;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Controller
{
    /**
     * @throws \Exception
     */
    protected function render($path, $attributes = [], int $status = 200): Response
    {
        $views = __DIR__ . '/';
        $cache = __DIR__ . '/../../var/cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $blade->pipeEnable = true;

        $content = $blade->run($path, $attributes);

        return new Response($content, $status);
    }

    protected function redirect($path, $messages = []): Response
    {
        foreach ($messages as $messageKey => $message) {
            (new Session())->getFlashBag()->add($messageKey, $message);
        }

        return new RedirectResponse($path);
    }
}