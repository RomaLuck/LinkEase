<?php

namespace Src\Http\About;

use Src\Http\Controller;

class AboutController extends Controller
{
    public function __invoke(): void
    {
        $this->render('About.about');
    }
}
