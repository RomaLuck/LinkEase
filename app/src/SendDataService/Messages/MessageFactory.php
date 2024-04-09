<?php

namespace Src\SendDataService\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use Src\SendDataService\Messages\Weather\WeatherEmailMessage;
use Src\SendDataService\Messages\Weather\WeatherTelegramMessage;

class MessageFactory
{
    private array $prototypes = [];
    private string $feature;
    private string $messenger;

    public function __construct(string $feature, string $messenger)
    {
        $this->feature = $feature;
        $this->messenger = $messenger;
        $this->setPrototypes();
    }

    public function getMessage(ArrayCollection $data): string
    {
        return $this->getFactory()->getMessage($data);
    }

    public function getFactory(): MessageInterface
    {
        $key = strtolower($this->feature) . ucfirst(strtolower($this->messenger));
        if (!isset($this->prototypes[$key])) {
            throw new \RuntimeException(sprintf('No message found for key %s', $key));
        }
        return $this->prototypes[$key];
    }

    private function setPrototypes(): void
    {
        $this->prototypes = [
            'weatherEmail' => new WeatherEmailMessage(),
            'weatherTelegram' => new WeatherTelegramMessage(),
        ];
    }
}