<?php

namespace Src\Http\Profile\Session;

use Src\Http\Controller;

class LoginViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('Profile.Session.create');
    }
}