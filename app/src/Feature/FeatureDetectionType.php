<?php

namespace Src\Feature;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\ClientInterface;
use Src\Feature\Api\Weather\WeatherFeature;
use Src\Feature\Db\Study\PHPStudyFeature;

enum FeatureDetectionType: string
{
    case WEATHER = FeatureTypes::WEATHER;
    case PHP_STUDY = FeatureTypes::PHP_STUDY;

    public function detect(ClientInterface $client, string $requestUrl, EntityManager $entityManager): FeatureInterface
    {
        return match ($this) {
            self::WEATHER => new WeatherFeature($client, $requestUrl),
            self::PHP_STUDY => new PHPStudyFeature($entityManager),
        };
    }
}