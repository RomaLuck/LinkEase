<?php

namespace Src\Features\Weather;

class WeatherData
{
    private array $weatherData;

    /**
     * @throws \JsonException
     */
    public function __construct(string $weatherData)
    {
        $this->weatherData = json_decode($weatherData, true, 512, JSON_THROW_ON_ERROR);
    }

    public function getCurrent(): array
    {
        return $this->weatherData['current'] ?? [];
    }

    public function getDaily()
    {
        return $this->weatherData['daily'] ?? [];
    }
}