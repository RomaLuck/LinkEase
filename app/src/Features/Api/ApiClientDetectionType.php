<?php

namespace Src\Features\Api;

use GuzzleHttp\ClientInterface;
use Src\Features\Api\Weather\WeatherApiClient;
use Src\Features\FeatureTypes;

enum ApiClientDetectionType: string
{
    case WEATHER = FeatureTypes::WEATHER;

    public function getClient(ClientInterface $client, string $requestUrl): ApiClientInterface
    {
        return match ($this) {
            self::WEATHER => new WeatherApiClient($client, $requestUrl)
        };
    }
}