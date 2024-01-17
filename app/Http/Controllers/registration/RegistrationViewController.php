<?php

namespace Http\Controllers\registration;

use Http\Controllers\Controller;

class RegistrationViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('registration/create.view.php');
    }
}
