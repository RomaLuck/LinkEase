<?php

namespace Src\SendDataService;

use GuzzleHttp\Client;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use Src\Feature\FeatureDetectionType;
use Src\Feature\FeatureInterface;
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

        $message = $feature->getMessage();
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
}