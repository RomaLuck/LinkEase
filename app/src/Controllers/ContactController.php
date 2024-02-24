<?php

namespace Src\Controllers;

class ContactController extends Controller
{
    public function __invoke(): void
    {
        $this->render('contact');
    }
}
