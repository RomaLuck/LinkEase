<?php

namespace Src\Controllers\features;

use Src\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class WeatherViewController extends Controller
{
    public function __invoke(Session $session): void
    {
        $this->render('weather-data.view.php', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
        ]);
    }
}