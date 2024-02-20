<?php

namespace Src\Features\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeocodingAPIClient
{
    private const REQUEST_URL = 'https://api.opencagedata.com/geocode/v1/json';

    public function __construct(private string $city, private string $country)
    {
    }

    /**
     * @throws \JsonException
     * @throws GuzzleException
     */
    public function getCoordinates(): array
    {
        $locationData = json_decode($this->getResponse(), true, 512, JSON_THROW_ON_ERROR);
        return $locationData['results'][0]['geometry'] ?? [];
    }

    /**
     * @throws GuzzleException
     */
    public function getResponse(): string
    {
        $queryParams = [
            'q' => "$this->city, $this->country",
            'key' => $_ENV['OPENCAGEDATE_KEY']
        ];

        return (new Client())->get(self::REQUEST_URL . '?' . http_build_query($queryParams))
            ->getBody()
            ->getContents();
    }
}