<?php

namespace Src\Features\Weather;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class WeatherApiClient
{
    private ClientInterface $client;
    private WeatherRequestParameters $parameters;

    public function __construct(
        ClientInterface          $client,
        WeatherRequestParameters $parameters,
    )
    {
        $this->client = $client;
        $this->parameters = $parameters;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getWeatherData(): WeatherData
    {
        $response = $this->client->get($this->parameters->getRequestUrl());

        return new WeatherData($response->getBody()->getContents());
    }
}