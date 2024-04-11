<?php

namespace Src\SendDataService;

use GuzzleHttp\Client;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use Src\Features\FeatureDetectionType;
use Src\Features\FeatureInterface;
use Src\Messages\MessageFactory;
use Src\SendDataService\Messengers\SendDataInterface;

class AdaptiveMessageSender
{
    public function __construct(private UserSettings $userSettings)
    {
    }

    public function sendMessage(): void
    {
        $user = $this->userSettings->getUser();

        $messenger = $this->getMessenger();
        $feature = $this->getFeature();

        assert($messenger !== null && $feature !== null, 'Messenger or data is not set');

        $message = $this->getMessage($feature);
        $messenger->send($user, $message);
    }

    /**
     * @return SendDataInterface|null
     */
    public function getMessenger(): ?SendDataInterface
    {
        return SendDataDetectionType::tryFrom($this->userSettings->getMessageType())?->detect();
    }

    /**
     * @return FeatureInterface|null
     */
    public function getFeature(): ?FeatureInterface
    {
        return FeatureDetectionType::tryFrom($this->userSettings->getFeatureType())
            ?->detect(new Client(), $this->userSettings->getApiRequestUrl(), EntityManagerFactory::create());
    }

    /**
     * @param FeatureInterface $feature
     * @return string
     */
    public function getMessage(FeatureInterface $feature): string
    {
        return (new MessageFactory(
            $this->userSettings->getFeatureType(),
            $this->userSettings->getMessageType()
        ))->getMessage($feature->getData());
    }
}