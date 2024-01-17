<?php

namespace Http\Controllers\session;

use Core\Security\Authenticator;
use Http\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;

class AuthSessionDestroyController extends Controller
{
    #[NoReturn]
    public function __invoke(): void
    {
        (new Authenticator)->logout();

        redirect('/');
    }
}
