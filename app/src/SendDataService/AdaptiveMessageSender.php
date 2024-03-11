<?php

namespace Src\SendDataService;

use GuzzleHttp\Client;
use Src\Entity\UserSettings;
use Src\Features\Api\ApiClientDetectionType;
use Src\SendDataService\Detections\SendDataDetectionType;

class AdaptiveMessageSender
{
    public function __construct(private UserSettings $userSettings)
    {
    }

    public function sendMessage(): void
    {
        $user = $this->userSettings->getUser();
        $messenger = SendDataDetectionType::tryFrom($this->userSettings->getMessageType())?->detect();
        $apiClient = ApiClientDetectionType::tryFrom($this->userSettings->getFeatureType())
            ?->getClient(new Client(), $this->userSettings->getApiRequestUrl());
        assert($messenger !== null && $apiClient !== null, 'Messenger or data is not set');
        $data = $apiClient->getResponseCollection();
        $messenger->send($user, $data);
    }
}