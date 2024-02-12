<?php

namespace Http\Controllers;

use Core\Container;
use Core\WeatherApiClient;

class WeatherDataController extends Controller
{
    public function __invoke(Container $container): void
    {
        $weatherApiClient = new WeatherApiClient($_POST['latitude'], $_POST['longitude']);

        $currentWeatherData = $weatherApiClient
            ->setForecastDays($_POST['forecast-length'])
            ->setCurrent(array_values($_POST['current-values'] ?? []))
            ->getWeatherDataHandler()
            ->getCurrentWeatherData();

        $dailyWeatherData = $weatherApiClient
            ->setForecastDays($_POST['forecast-length'])
            ->setDaily(array_values($_POST['daily-values'] ?? []))
            ->getWeatherDataHandler()
            ->getDailyWeatherData();

        $this->render('weather-data.view.php', [
            'currentWeatherData' => $currentWeatherData,
            'dailyWeatherData' => $dailyWeatherData,
        ]);
    }
}