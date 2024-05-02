<?php

namespace Src\SendDataService\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use Src\SendDataService\Messages\PHPStudy\PHPStudyEmailMessage;
use Src\SendDataService\Messages\PHPStudy\PHPStudyTelegramMessage;
use Src\SendDataService\Messages\Weather\WeatherEmailMessage;
use Src\SendDataService\Messages\Weather\WeatherTelegramMessage;

class MessageFactory
{
    private string $feature;
    private string $messenger;

    public function __construct(string $feature, string $messenger)
    {
        $this->feature = $feature;
        $this->messenger = $messenger;
    }

    public function getMessage(ArrayCollection $data): string
    {
        return $this->getFactory()->getMessage($data);
    }

    public function getFactory(): MessageInterface
    {
        foreach ($this->getPrototypes() as $prototype) {
            if ($prototype->getFeature() === $this->feature && $prototype->getMessenger() === $this->messenger) {
                return $prototype;
            }
        }
        throw new \RuntimeException('Prototype not found');
    }

    private function getPrototypes(): array
    {
        return [
            new PHPStudyEmailMessage(),
            new PHPStudyTelegramMessage(),
            new WeatherEmailMessage(),
            new WeatherTelegramMessage(),
        ];
    }
}