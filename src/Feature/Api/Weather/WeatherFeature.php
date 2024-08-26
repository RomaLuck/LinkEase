<?php

namespace Src\Feature\Api\Weather;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Src\Feature\FeatureInterface;
use Src\SendDataService\Messages\WeatherMessage;

class WeatherFeature implements FeatureInterface
{
    public function __construct(private ClientInterface $client, private string $requestUrl)
    {
    }


    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getMessage(): string
    {
        return (new WeatherMessage($this->getWeatherData()))->getMessage();
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getWeatherData(): ArrayCollection
    {
        $responseJson = $this->client->get($this->requestUrl)->getBody()->getContents();
        $weatherData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        return new ArrayCollection($weatherData);
    }
}