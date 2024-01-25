<?php

namespace integration;

use Core\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private const MAIN_URL = 'http://localhost';
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
        $this->assertEquals(Response::NOT_FOUND, $result);
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
        ];
    }
}