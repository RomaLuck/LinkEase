<?php

namespace Src\Http\Contact;

use Src\Http\Controller;

class ContactController extends Controller
{
    public function __invoke(): void
    {
        $this->render('Contact.contact');
    }
}
