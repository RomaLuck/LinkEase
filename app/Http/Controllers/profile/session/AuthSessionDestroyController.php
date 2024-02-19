<?php

namespace Http\Controllers\profile\session;

use Core\Container;
use Core\Security\Authenticator;
use Http\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;
use function Http\Controllers\session\redirect;

class AuthSessionDestroyController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Container $container): void
    {
        $container->get(Authenticator::class)?->logout();

        $this->redirect('/');
    }
}
