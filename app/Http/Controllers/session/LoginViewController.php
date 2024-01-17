<?php

namespace Http\Controllers\session;

use Http\Controllers\Controller;

class LoginViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('session/create.view.php');
    }
}