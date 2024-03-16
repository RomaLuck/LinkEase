<?php

namespace integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Src\Features\Api\Weather\WeatherFeature;
use Src\Features\Api\Weather\WeatherRequestParameters;

class WeatherFeatureTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function testGetWeatherResponse(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"current": {"weather":"sunny"}}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $weatherRequestParameters = new WeatherRequestParameters(50.4501, 30.5234);
        $weatherApiClient = new WeatherFeature($client, $weatherRequestParameters->getRequestUrl());

        $this->assertEquals(['weather' => 'sunny'], $weatherApiClient->getWeatherData()->get('current'));
    }
}