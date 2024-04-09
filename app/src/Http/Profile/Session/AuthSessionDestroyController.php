<?php

namespace Src\Http\Profile\Session;

use Src\Http\Controller;
use Src\Security\Authenticator;
use Symfony\Component\HttpFoundation\Response;

class AuthSessionDestroyController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Authenticator $authenticator): Response
    {
        $authenticator->logout();

        return $this->redirect('/');
    }
}
