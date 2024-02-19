<?php

namespace Http\Controllers\features;

use Http\Controllers\Controller;

class WeatherViewController extends Controller
{
    public function __invoke(): void
    {
        $this->render('weather-data.view.php', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
        ]);
    }
}