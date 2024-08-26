<?php

namespace Src\Http\Profile\Session;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoginViewController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Profile.Session.create');
    }
}