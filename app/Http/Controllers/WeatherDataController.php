<?php

namespace Http\Controllers;

use Core\Container;
use Core\WeatherApiClient;

class WeatherDataController extends Controller
{
    public function __invoke(Container $container): void
    {
        $weatherData = (new WeatherApiClient())
            ->setLatitude($_POST['latitude'])
            ->setLongitude($_POST['longitude'])
            ->setForecastDays($_POST['forecast-length'])
            ->setDaily(array_values($_POST['daily-values'] ?? []))
            ->setHourly(array_values($_POST['hourly-values'] ?? []))
            ->getWeatherDataHandler()
            ->getDailyWeatherData();

        $this->render('weather-data.view.php', [
            'weatherData' => $weatherData
        ]);
    }
}