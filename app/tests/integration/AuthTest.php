<?php

namespace integration;

use Src\Container;
use Src\Database;
use Src\Security\Authenticator;
use Src\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PDO;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private const USERNAME = 'test';
    private const EMAIL = 'test@gmail.com';
    private const PASSWORD = 'test';
    private ?PDO $pdo;
    private ?Container $container;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
        $this->container = new Container();
        $db = $this->container->get(Database::class);
        $this->pdo = $db->getConnection();
        $this->pdo->beginTransaction();
        $db->query('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)', [
            'username' => self::USERNAME,
            'email' => self::EMAIL,
            'password' => password_hash(self::PASSWORD, PASSWORD_BCRYPT)
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->pdo->rollBack();
        $this->pdo = null;
        $this->client = null;
        $this->container = null;
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function testUserAuthenticationSuccess(): void
    {
        $signIn = $this->container->get(Authenticator::class)->authenticate(self::EMAIL, self::PASSWORD);
        $this->assertTrue($signIn);
        $this->assertTrue(Session::has('user'));
    }
}