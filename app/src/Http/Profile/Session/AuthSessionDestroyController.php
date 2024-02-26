<?php

namespace Src\Http\Profile\Session;

use JetBrains\PhpStorm\NoReturn;
use Src\Http\Controller;
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
