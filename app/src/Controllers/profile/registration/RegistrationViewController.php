<?php

namespace Src\Controllers\profile\registration;

use Src\Controllers\Controller;

class RegistrationViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('registration.create');
    }
}
