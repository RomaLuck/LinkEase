<?php

namespace Http\Controllers;

class AboutController extends Controller
{
    public function __invoke(): void
    {
        $this->render('about.view.php');
    }
}
