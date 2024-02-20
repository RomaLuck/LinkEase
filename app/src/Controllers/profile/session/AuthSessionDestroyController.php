<?php

namespace Src\Controllers\profile\session;

use Src\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;
use Src\Security\Authenticator;

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
