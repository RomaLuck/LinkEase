<?php

namespace integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Src\Features\Weather\WeatherApiClient;
use Src\Features\Weather\WeatherRequestParameters;

class WeatherApiClientTest extends TestCase
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
        $weatherApiClient = new WeatherApiClient($client, $weatherRequestParameters);

        $this->assertEquals(['weather' => 'sunny'], $weatherApiClient->getWeatherData()->getCurrent());
    }
}