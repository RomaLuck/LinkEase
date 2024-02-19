<?php

namespace Http\Controllers\profile\session;

use Core\Security\Authenticator;
use Http\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;

class AuthSessionDestroyController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Authenticator $authenticator): void
    {
        $authenticator->logout();

        $this->redirect('/');
    }
}
