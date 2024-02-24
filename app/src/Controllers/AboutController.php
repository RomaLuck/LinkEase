<?php

namespace Src\Controllers;

class AboutController extends Controller
{
    public function __invoke(): void
    {
        $this->render('about');
    }
}
