<?php

namespace Src\Http\Features\Weather;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use GuzzleHttp\Exception\GuzzleException;
use Src\Entity\User;
use Src\Entity\UserSettings;
use Src\Features\Weather\WeatherApiClient;
use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class WeatherDataController extends Controller
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     * @throws \Exception|ORMException
     */
    public function __invoke(EntityManager $entityManager, Request $request, Session $session): Response
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
            return $this->redirect('/');
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

        $cityCookie = Cookie::create('city', $city)->withSecure();
        $latitudeCookie = Cookie::create('latitude', $latitude)->withSecure();
        $longitudeCookie = Cookie::create('longitude', $longitude)->withSecure();

        $response = $this->render('Features.Weather.weather-data', [
            'currentWeatherData' => $weatherRawData->getWeatherDataHandler()->getCurrentWeatherData(),
            'dailyWeatherData' => $weatherRawData->getWeatherDataHandler()->getDailyWeatherData(),
            'city' => $cityCookie->getValue(),
            'latitude' => $latitudeCookie->getValue(),
            'longitude' => $longitudeCookie->getValue(),
        ]);

        $response->headers->setCookie($cityCookie);
        $response->headers->setCookie($latitudeCookie);
        $response->headers->setCookie($longitudeCookie);

        return $response;
    }
}