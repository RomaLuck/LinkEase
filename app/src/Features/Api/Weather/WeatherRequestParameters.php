<?php

namespace Src\Features\Api\Weather;

class WeatherRequestParameters
{
    private const API_URL = 'https://api.open-meteo.com/v1/forecast';
    private array $parameters = [];
    private string $requestUrl = '';

    public function __construct(float $latitude, float $longitude)
    {
        $this->parameters['latitude'] = $latitude;
        $this->parameters['longitude'] = $longitude;
    }

    public static function createFromRequestUrl(string $requestUrl): self
    {
        $query = parse_url($requestUrl)['query'] ?? '';
        if ($query === '') {
            throw new \RuntimeException('Query is empty');
        }

        parse_str($query, $queryData);

        $self = new self($queryData['latitude'], $queryData['longitude']);
        $self->setParameters($queryData);

        return $self;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }
    }

    public function getLatitude(): float
    {
        return $this->parameters['latitude'];
    }

    public function getLongitude(): float
    {
        return $this->parameters['longitude'];
    }

    public function getElevation(): float
    {
        return $this->parameters['elevation'];
    }

    public function setElevation(float $elevation): self
    {
        $this->parameters['elevation'] = $elevation;

        return $this;
    }

    public function getHourlyParameters(): array
    {
        return $this->parameters['hourly'];
    }

    public function setHourlyParameters(array $hourly): self
    {
        $this->parameters['hourly'] = $hourly;

        return $this;
    }

    public function getDailyParameters(): array
    {
        return $this->parameters['daily'];
    }

    public function setDailyParameters(array $daily): self
    {
        $this->parameters['daily'] = $daily;

        return $this;
    }

    public function getCurrentParameters(): array
    {
        return $this->parameters['current'];
    }

    public function setCurrentParameters(array $current): self
    {
        $this->parameters['current'] = $current;

        return $this;
    }

    public function getTemperatureUnit(): string
    {
        return $this->parameters['temperature_unit'];
    }

    public function setTemperatureUnit(string $temperatureUnit): self
    {
        $this->parameters['temperature_unit'] = $temperatureUnit;

        return $this;
    }

    public function getWindSpeedUnit(): string
    {
        return $this->parameters['wind_speed_unit'];
    }

    public function setWindSpeedUnit(string $windSpeedUnit): self
    {
        $this->parameters['wind_speed_unit'] = $windSpeedUnit;

        return $this;
    }

    public function getPrecipitationUnit(): string
    {
        return $this->parameters['precipitation_unit'];
    }

    public function setPrecipitationUnit(string $precipitationUnit): self
    {
        $this->parameters['precipitation_unit'] = $precipitationUnit;

        return $this;
    }

    public function getTimeFormat(): string
    {
        return $this->parameters['time_format'];
    }

    public function setTimeFormat(string $timeFormat): self
    {
        $this->parameters['time_format'] = $timeFormat;

        return $this;
    }

    public function getTimezone(): string
    {
        return $this->parameters['timezone'];
    }

    public function setTimezone(string $timezone): self
    {
        $this->parameters['timezone'] = $timezone;

        return $this;
    }

    public function getPastDays(): int
    {
        return $this->parameters['past_days'];
    }

    public function setPastDays(int $pastDays): self
    {
        $this->parameters['past_days'] = $pastDays;

        return $this;
    }

    public function getForecastDays(): int
    {
        return $this->parameters['forecast_days'];
    }

    public function setForecastDaysLength(int $forecastDays): self
    {
        $this->parameters['forecast_days'] = $forecastDays;

        return $this;
    }

    public function getStartDate(): string
    {
        return $this->parameters['start_date'];
    }

    public function setStartDate(string $startDate): self
    {
        $this->parameters['start_date'] = $startDate;

        return $this;
    }

    public function getEndDate(): string
    {
        return $this->parameters['end_date'];
    }

    public function setEndDate(string $endDate): self
    {
        $this->parameters['end_date'] = $endDate;

        return $this;
    }

    public function getModels(): array
    {
        return $this->parameters['models'];
    }

    public function setModels(array $models): self
    {
        $this->parameters['models'] = $models;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function setRequestUrl(string $url): self
    {
        $this->requestUrl = $url;

        return $this;
    }

    public function assemble(): self
    {
        $this->requestUrl = self::API_URL . '?' . http_build_query($this->getParameters());

        return $this;
    }

    public function addParameter($key, $value): self
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public static function getDailyParametersList(): array
    {
        return [
            'temperature_2m_max',
            'temperature_2m_min',
            'precipitation_sum',
            'precipitation_hours',
            'wind_speed_10m_max',
        ];
    }

    public  static function getCurrentParametersList(): array
    {
        return [
            'pressure_msl',
            'temperature_2m',
            'relative_humidity_2m',
            'precipitation',
            'rain',
            'cloud_cover',
            'wind_speed_10m'
        ];
    }
}