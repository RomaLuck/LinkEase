<?php

namespace Src\Features;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\ClientInterface;
use Src\Features\Api\Weather\WeatherFeature;
use Src\Features\Db\Study\PhpStudyFeature;

enum FeatureDetectionType: string
{
    case WEATHER = FeatureTypes::WEATHER;
    case PHP_STUDY = FeatureTypes::PHP_STUDY;

    public function detect(ClientInterface $client, string $requestUrl, EntityManager $entityManager): FeatureInterface
    {
        return match ($this) {
            self::WEATHER => new WeatherFeature($client, $requestUrl),
            self::PHP_STUDY => new PhpStudyFeature($entityManager),
        };
    }
}