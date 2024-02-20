<?php

namespace Src\Controllers\profile\session;

use Src\Controllers\Controller;

class LoginViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('session/create.view.php');
    }
}