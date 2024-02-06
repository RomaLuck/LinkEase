<?php

namespace Http\Controllers;

use Core\Container;

class WeatherViewController extends Controller
{
    public function __invoke(Container $container): void
    {
        $this->render('weather-data.view.php', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
        ]);
    }
}