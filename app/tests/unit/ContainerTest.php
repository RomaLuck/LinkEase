<?php

namespace unit;

use Core\Container;
use Core\Validator;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private ?Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->container = null;
    }

    /**
     * @throws \Exception
     */
    public function testResolve(): void
    {
        $this->container->bind(Validator::class, function () {
            return new Validator();
        });

        $this->assertInstanceOf(Validator::class, $this->container->resolve(Validator::class));
    }
}