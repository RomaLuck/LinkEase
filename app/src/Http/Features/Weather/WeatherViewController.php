<?php

namespace Src\Http\Features\Weather;

use Src\Http\Controller;
use Src\SendDataService\MessageTypes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherViewController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $cookie = $request->cookies;

        return $this->render('Features.Weather.weather-data', [
            'opencagedataKey' => $_ENV['OPENCAGEDATE_KEY'],
            'city' => $cookie->get('city') ?? '',
            'latitude' => $cookie->get('latitude') ?? '',
            'longitude' => $cookie->get('longitude') ?? '',
            'messageTypes' => MessageTypes::getAll()
        ]);
    }
}