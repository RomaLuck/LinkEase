<?php

namespace Src\Http\Profile\Registration;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;

class RegistrationViewController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Profile.Registration.create');
    }
}
