<?php

namespace Http\Controllers;

use Core\Container;
use Core\Database;
use Core\Session;
use Core\WeatherApiClient;

class WeatherDataController extends Controller
{
    public function __invoke(Container $container): void
    {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $city = $_POST['city'];
        $userId = Session::get('user')['id'];

        $weatherRawData = (new WeatherApiClient($latitude, $longitude))
            ->setForecastDays($_POST['forecast-length'])
            ->setParametersManually('current', array_values($_POST['current-values'] ?? []))
            ->setParametersManually('daily', array_values($_POST['daily-values'] ?? []));

        $weatherRequestUrl = $weatherRawData->getRequestUrl();

        /**
         * @var Database $db
         */
        $db = $container->get(Database::class);

        $userConfiguration = $db->query('SELECT * FROM user_settings WHERE user_id=:user_id', [
            'user_id' => $userId,
        ])->fetch();

        if ($userConfiguration) {
            $db->query('UPDATE user_settings SET city=:city, latitude=:latitude, longitude=:longitude, weather_setting=:weather_setting WHERE user_id=:user_id', [
                'user_id' => $userId,
                'city' => $city,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'weather_setting' => $weatherRequestUrl
            ]);
        } else {
            $db->query('INSERT INTO user_settings(user_id, city, latitude, longitude, weather_setting) VALUES(:user_id, :city,:latitude, :longitude, :weather_setting)', [
                'user_id' => $userId,
                'city' => $city,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'weather_setting' => $weatherRequestUrl
            ]);
        }

        $this->render('weather-data.view.php', [
            'currentWeatherData' => $weatherRawData->getWeatherDataHandler()->getCurrentWeatherData(),
            'dailyWeatherData' => $weatherRawData->getWeatherDataHandler()->getDailyWeatherData(),
            'city' => $userConfiguration['city'] ?? '',
            'latitude' => $userConfiguration['latitude'] ?? '',
            'longitude' => $userConfiguration['longitude'] ?? '',
        ]);
    }
}