<?php

namespace Core\Features\Weather;

class WeatherDataHandler
{
    private string $weatherData;

    public function __construct(string $weatherData)
    {
        $this->weatherData = $weatherData;
    }

    /**
     * @throws \JsonException
     */
    public function getWeatherData(): array
    {
        return json_decode($this->weatherData, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws \JsonException
     */
    public function getCurrentWeatherData(): array
    {
        return $this->getWeatherData()['current'] ?? [];
    }

    /**
     * @throws \JsonException
     */
    public function getDailyWeatherData()
    {
        return $this->getWeatherData()['daily'] ?? [];
    }
}