<?php

namespace Src\SendDataService;

use GuzzleHttp\Client;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use Src\Features\FeatureDetectionType;
use Src\SendDataService\Detections\SendDataDetectionType;

class AdaptiveMessageSender
{
    public function __construct(private UserSettings $userSettings)
    {
    }

    public function sendMessage(): void
    {
        $entityManager = EntityManagerFactory::create();

        $user = $this->userSettings->getUser();

        $messenger = SendDataDetectionType::tryFrom($this->userSettings->getMessageType())?->detect();
        $apiClient = FeatureDetectionType::tryFrom($this->userSettings->getFeatureType())
            ?->detect(new Client(), $this->userSettings->getApiRequestUrl(), $entityManager);

        assert($messenger !== null && $apiClient !== null, 'Messenger or data is not set');

        $data = $apiClient->getResponseCollection();
        $messenger->send($user, $data);
    }
}