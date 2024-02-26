<?php

namespace Src\Http;

class HomeController extends Controller
{
    public function __invoke(): void
    {
        $this->render('index');
    }
}