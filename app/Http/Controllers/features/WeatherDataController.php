<?php

namespace Http\Controllers\features;

use Core\Database;
use Core\Features\Weather\WeatherApiClient;
use Core\Session;
use Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;

class WeatherDataController extends Controller
{
    public function __invoke(Database $db, Request $request): void
    {
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        $city = $request->request->get('city');
        $time = $request->request->get('time-execute');
        $userId = Session::get('user')['id'];

        $weatherRawData = (new WeatherApiClient($latitude, $longitude))
            ->setForecastDays($request->request->get('forecast-length'))
            ->setParametersManually('current', array_values($request->request->all('current-values')))
            ->setParametersManually('daily', array_values($request->request->all('daily-values')));

        $weatherRequestUrl = $weatherRawData->getRequestUrl();

        $userConfiguration = $db->query('SELECT * FROM user_settings WHERE user_id=:user_id', [
            'user_id' => $userId,
        ])->fetch();

        if ($userConfiguration) {
            $db->query('UPDATE user_settings SET time_execute=:time_execute, city=:city, latitude=:latitude, longitude=:longitude, weather_setting=:weather_setting WHERE user_id=:user_id', [
                'time_execute' => $time,
                'user_id' => $userId,
                'city' => $city,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'weather_setting' => $weatherRequestUrl
            ]);
        } else {
            $db->query('INSERT INTO user_settings(time_execute, user_id, city, latitude, longitude, weather_setting) VALUES(:time_execute, :user_id, :city,:latitude, :longitude, :weather_setting)', [
                'time_execute' => $time,
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