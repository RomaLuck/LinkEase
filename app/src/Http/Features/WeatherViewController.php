<?php

namespace Src\Http\Features;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class WeatherViewController extends Controller
{
    public function __invoke(Session $session): void
    {
        $this->render('Features.weather-data', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
        ]);
    }
}