<?php

namespace unit;

use Src\SendDataService\Messages\MessageFactory;
use Src\SendDataService\Messages\Weather\WeatherEmailMessage;
use PHPUnit\Framework\TestCase;

class MessageFactoryTest extends TestCase
{
    public function testGetFactory(): void
    {
        $factory = new MessageFactory('weather', 'email');
        self::assertInstanceOf(WeatherEmailMessage::class, $factory->getFactory());
    }
}