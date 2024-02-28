<?php

namespace integration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Src\Database\EntityManagerFactory;
use Src\Entity\User;
use Src\Security\Authenticator;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthTest extends TestCase
{
    private const USERNAME = 'test';
    private const EMAIL = 'test@gmail.com';
    private const PASSWORD = 'test';
    private ?EntityManager $entityManager;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->entityManager = EntityManagerFactory::create();
        if (!$this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->beginTransaction();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }
        $this->entityManager = null;
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     * @throws ORMException
     */
    public function testUserAuthenticationSuccess(): void
    {
        $user = new User();
        $user->setName(self::USERNAME)
            ->setEmail(self::EMAIL)
            ->setPassword(password_hash(self::PASSWORD, PASSWORD_BCRYPT));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $authenticator = new Authenticator($this->entityManager, new Session());
        $signIn = $authenticator->authenticate(self::EMAIL, self::PASSWORD);

        $this->assertTrue($signIn);

        $savedUser = $this->entityManager->getRepository(User::class)->findOneByEmail(self::EMAIL);
        $this->assertNotNull($savedUser);
        $this->assertEquals(self::USERNAME, $savedUser->getName());
        $this->assertEquals(self::EMAIL, $savedUser->getEmail());
    }
}