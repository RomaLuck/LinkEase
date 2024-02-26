<?php

namespace Src\Http\Contact;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Contact.contact');
    }
}
