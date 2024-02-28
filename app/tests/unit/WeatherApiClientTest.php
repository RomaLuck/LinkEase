<?php

namespace unit;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Src\Features\Weather\WeatherApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class WeatherApiClientTest extends TestCase
{
    private WeatherApiClient $weatherApiClient;

    protected function setUp(): void
    {
        $this->weatherApiClient = new WeatherApiClient(50.4501, 30.5234); // Coordinates for Kyiv, Ukraine
    }

    /**
     * @throws GuzzleException
     */
    public function testGetWeatherDataHandler(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"weather": "sunny"}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $weatherDataHandler = $this->weatherApiClient->getWeatherDataHandler();

        $this->assertEquals('sunny', $weatherDataHandler->getWeather());
    }

    public function testGetWeatherResponse(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '{"weather": "sunny"}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $this->weatherApiClient->getWeatherResponse($client);

        $this->assertEquals('{"weather": "sunny"}', $response);
    }
}
