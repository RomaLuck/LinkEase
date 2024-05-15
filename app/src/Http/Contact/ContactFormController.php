<?php

namespace Src\Http\Contact;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ContactFormController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Contact.contact', [
            'session' => new Session()
        ]);
    }
}
