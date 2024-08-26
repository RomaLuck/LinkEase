<?php

namespace unit;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Src\Entity\UserSettings;
use Src\Feature\Api\Weather\WeatherFeature;
use Src\SendDataService\AdaptiveMessageSender;
use Src\SendDataService\Messages\WeatherMessage;
use Src\SendDataService\Messengers\EmailMessenger;

class AdaptiveMessageSenderTest extends TestCase
{
    private AdaptiveMessageSender $sender;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $userSettings = $this->createMock(UserSettings::class);
        $userSettings->method('getMessageType')
            ->willReturn('email');
        $userSettings->method('getFeatureType')
            ->willReturn('weather');
        $userSettings->method('getApiRequestUrl')
            ->willReturn('apiRequestUrl');
        $this->sender = new AdaptiveMessageSender($userSettings);
    }

    public function testFeature(): void
    {
        self::assertInstanceOf(WeatherFeature::class, $this->sender->getFeature());
    }

    public function testMessenger(): void
    {
        self::assertInstanceOf(EmailMessenger::class, $this->sender->getMessenger());
    }

    public function testGetMessage(): void
    {
        $data = new ArrayCollection([
            'current_units' => [
                'time' => 'iso8601',
                'interval' => 'seconds',
                'temperature_2m' => '°C',
                'relative_humidity_2m' => '%',
            ],
            'current' => [
                'time' => '2024-04-09T19:15',
                'interval' => '900',
                'temperature_2m' => '13.4',
                'relative_humidity_2m' => '60'
            ],
            'daily_units' => [
                'time' => 'iso8601',
                'temperature_2m_max' => '°C',
                'temperature_2m_min' => '°C',
            ],
            'daily' => [
                'time' => ['2024-04-09'],
                'temperature_2m_max' => ['26.2'],
                'temperature_2m_min' => ['11.2']
            ]
        ]);

        $feature = $this->getMockBuilder(WeatherFeature::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getMessage'])
            ->getMock();
        $feature->method('getMessage')
            ->willReturn((new WeatherMessage($data))->getMessage());

        $message = $feature->getMessage();
        $expects = '<h4>Daily:</h4><p><b>time</b> : 2024-04-09(iso8601), </p><p><b>temperature max</b> : 26.2(°C), </p><p><b>temperature min</b> : 11.2(°C), </p><h4>Current:</h4><p><b>time</b> : 2024-04-09T19:15(iso8601), </p><p><b>interval</b> : 900(seconds), </p><p><b>temperature </b> : 13.4(°C), </p><p><b>relative humidity </b> : 60(%), </p>';

        self::assertEquals($expects, $message);
    }
}