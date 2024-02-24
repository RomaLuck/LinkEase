<?php

namespace Src\Controllers\features;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\Exception\GuzzleException;
use Src\Controllers\Controller;
use Src\Entity\User;
use Src\Entity\UserSettings;
use Src\Features\Weather\WeatherApiClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class WeatherDataController extends Controller
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     * @throws \Exception
     */
    public function __invoke(EntityManager $entityManager, Request $request, Session $session): void
    {
        $latitude = $request->request->get('latitude');
        $longitude = $request->request->get('longitude');
        $city = $request->request->get('city');
        $time = $request->request->get('time-execute');
        $userId = $session->get('user')['id'];

        $user = $entityManager->getRepository(User::class)->findOneBy([
            'id' => $userId
        ]);

        if ($user === null) {
            $this->redirect('/');
        }

        $weatherRawData = (new WeatherApiClient($latitude, $longitude))
            ->setForecastDays($request->request->get('forecast-length'))
            ->setParametersManually('current', array_values($request->request->all('current-values')))
            ->setParametersManually('daily', array_values($request->request->all('daily-values')));

        $weatherRequestUrl = $weatherRawData->getRequestUrl();

        $userConfiguration = $entityManager
            ->getRepository(UserSettings::class)
            ->findOneBy(['user' => $user])
            ?? new UserSettings();

        $userConfiguration->setTime(new \DateTime($time))
            ->setApiRequestUrl($weatherRequestUrl)
            ->setUser($user);

        $entityManager->persist($userConfiguration);
        $entityManager->flush();

        #@todo засетати в кукіси місто і координати

        $this->render('features.weather-data', [
            'currentWeatherData' => $weatherRawData->getWeatherDataHandler()->getCurrentWeatherData(),
            'dailyWeatherData' => $weatherRawData->getWeatherDataHandler()->getDailyWeatherData(),
//            'city' => $userConfiguration['city'] ?? '',
//            'latitude' => $userConfiguration['latitude'] ?? '',
//            'longitude' => $userConfiguration['longitude'] ?? '',
        ]);
    }
}