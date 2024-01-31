<?php

namespace Core;

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
    private function getHourlyWeatherData(): array
    {
        return $this->getWeatherData()['hourly'] ?? [];
    }

    /**
     * @throws \JsonException
     */
    public function getDataByTime(string $data): array
    {
        if (array_key_exists($data, $this->getHourlyWeatherData())) {
            return array_combine(
                $this->getHourlyWeatherData()['time'],
                $this->getHourlyWeatherData()[$data]
            );
        }
        return [];
    }

    /**
     * @throws \JsonException
     */
    public function getDailyWeatherData(string $data)
    {
        return $this->getWeatherData()['daily'] ?? [];
    }
}