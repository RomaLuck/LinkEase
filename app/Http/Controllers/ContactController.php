<?php

namespace Http\Controllers;

class ContactController extends Controller
{
    public function __invoke(): void
    {
        $this->render('contact.view.php');
    }
}
