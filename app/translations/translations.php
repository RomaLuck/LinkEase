<?php

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

$translator = new Translator('en_GB');
$translator->addLoader('array', new ArrayLoader());
$translator->addResource('array', [
    'temperature_2m_max' => 'Temperature max',
    'temperature_2m_min' => 'Temperature min',
    'precipitation_sum' => 'Precipitation',
    'precipitation_hours' => 'Precipitation hours',
    'temperature_2m' => 'Temperature',
    'relative_humidity_2m' => 'Relative Humidity',
    'pressure_msl' => 'Pressure',
    'cloud_cover' => 'Cloud Cover',
    'wind_speed_10m' => 'Wind Speed',
    'precipitation' => 'Precipitation',
    'snowfall' => 'Snowfall',
    'rain' => 'Rain',
    'interval' => 'Interval',
    'wind_speed_10m_max' => 'Wind Speed'
], 'en_GB');
$translator->addResource('array', [
    'temperature_2m' => 'Температура',
], 'uk_UA');