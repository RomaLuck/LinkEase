<?php

namespace integration;

use Src\Container;
use Src\Database;
use Src\Entity\User;
use Src\Security\Authenticator;
use GuzzleHttp\Exception\GuzzleException;
use PDO;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private const USERNAME = 'test';
    private const EMAIL = 'test@gmail.com';
    private const PASSWORD = 'test';
    private ?Container $container;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->entityManager = Database\EntityManagerFactory::create();
        $this->entityManager->beginTransaction();
        $user = new User();
        $user->setName(self::USERNAME)
            ->setEmail(self::EMAIL)
            ->setPassword(password_hash(self::PASSWORD, PASSWORD_BCRYPT));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->rollBack();
        $this->entityManager = null;
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
    }
}