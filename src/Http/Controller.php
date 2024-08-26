<?php

namespace Src\Http;

use eftec\bladeone\BladeOne;
use Src\ExceptionHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;

class Controller
{
    protected function render($path, $attributes = [], int $status = 200): Response
    {
        $views = __DIR__ . '/';
        $cache = __DIR__ . '/../../var/cache';

        $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $blade->pipeEnable = true;

        $locale = 'en_GB';

        $translator = new Translator($locale);
        $translator->addLoader('array', new PhpFileLoader());
        $translator->addResource(
            'array',
            __DIR__ . '/../../translations/translation.' . $locale . '.php',
            $locale
        );
        $attributes['translator'] = $translator;

        try {
            $content = $blade->run($path, $attributes);
        } catch (\Exception $exception) {
            ExceptionHandler::handle($exception);
            $content = $blade->run('Errors.500');
        }

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