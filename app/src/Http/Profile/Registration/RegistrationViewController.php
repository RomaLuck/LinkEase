<?php

namespace Src\Http\Profile\Registration;

use Src\Http\Controller;

class RegistrationViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('Profile.Registration.create');
    }
}
