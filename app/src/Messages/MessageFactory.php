<?php

namespace Src\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Messages\PHPStudy\PHPStudyEmailMessage;
use Src\Messages\PHPStudy\PHPStudyTelegramMessage;
use Src\Messages\Weather\WeatherEmailMessage;
use Src\Messages\Weather\WeatherTelegramMessage;

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