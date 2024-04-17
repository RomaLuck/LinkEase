<?php

namespace Src\Http;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
    public function __invoke(Session $session): Response
    {
        return $this->render('index', [
            'session' => $session
        ]);
    }
}