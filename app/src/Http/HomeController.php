<?php

namespace Src\Http;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('index');
    }
}