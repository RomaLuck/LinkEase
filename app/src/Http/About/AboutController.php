<?php

namespace Src\Http\About;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('About.about');
    }
}
