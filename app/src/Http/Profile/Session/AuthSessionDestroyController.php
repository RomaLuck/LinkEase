<?php

namespace Src\Http\Profile\Session;

use JetBrains\PhpStorm\NoReturn;
use Src\Http\Controller;
use Src\Security\Authenticator;
use Symfony\Component\HttpFoundation\Response;

class AuthSessionDestroyController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Authenticator $authenticator): Response
    {
        $authenticator->logout();

        return $this->redirect('/');
    }
}
