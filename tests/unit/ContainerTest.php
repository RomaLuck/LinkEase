<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Src\Container;
use Doctrine\ORM\EntityManager;
use Src\Security\Authenticator;
use Src\Security\OAuthAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ContainerTest extends TestCase
{
    private ?Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    protected function tearDown(): void
    {
        $this->container = null;
    }

    /**
     * @throws \Exception
     */
    public function testServicesRegistration(): void
    {
        $this->assertInstanceOf(EntityManager::class, $this->container->get(EntityManager::class));
        $this->assertInstanceOf(Session::class, $this->container->get(Session::class));
        $this->assertInstanceOf(Authenticator::class, $this->container->get(Authenticator::class));
        $this->assertInstanceOf(OAuthAuthenticator::class, $this->container->get(OAuthAuthenticator::class));
        $this->assertInstanceOf(Request::class, $this->container->get(Request::class));
    }
}
