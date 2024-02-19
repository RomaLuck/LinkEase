<?php

namespace Http\Controllers\features;

use Core\Container;
use Http\Controllers\Controller;

class WeatherViewController extends Controller
{
    public function __invoke(Container $container): void
    {
        $this->render('weather-data.view.php', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
        ]);
    }
}