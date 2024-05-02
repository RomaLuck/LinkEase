<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Src\SendDataService\Messages\MessageFactory;
use Src\SendDataService\Messages\Weather\WeatherEmailMessage;

class MessageFactoryTest extends TestCase
{
    public function testGetFactory(): void
    {
        $factory = new MessageFactory('weather', 'email');
        self::assertInstanceOf(WeatherEmailMessage::class, $factory->getFactory());
    }
}