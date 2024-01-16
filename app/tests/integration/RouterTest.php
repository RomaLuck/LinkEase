<?php

namespace integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require "Core/functions.php";

class RouterTest extends TestCase
{
    private const MAIN_URL = 'http://localhost:8000';
    private ?Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->client = null;
    }

    /**
     * @throws GuzzleException
     */
    #[DataProvider('getPaths')]
    public function testRoutes(int $expectedCode, string $path): void
    {
        $result = $this->client->get(self::MAIN_URL . $path, [
            'allow_redirects' => false,
        ])->getStatusCode();
        $this->assertEquals($expectedCode, $result);
    }

    /**
     * @throws GuzzleException
     */
    public function testNonExistentRoute(): void
    {
        $this->expectException(ClientException::class);

        $result = $this->client->get(self::MAIN_URL . '/nonExistentRoute')->getStatusCode();
        $this->assertEquals('404', $result);
    }

    public static function getPaths(): array
    {
        return [
            [200, '/contact'],
            [200, '/about'],
            [200, '/'],
            [200, '/login'],
            [200, '/register'],
            [302, '/profile'],
            [302, '/logout'],
        ];
    }
}