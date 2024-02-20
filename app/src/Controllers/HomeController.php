<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    public function __invoke(): void
    {
        $this->render('index.view.php');
    }
}