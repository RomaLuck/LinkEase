<?php

namespace Src\SendDataService;

use Src\SendDataService\Messengers\EmailMessenger;
use Src\SendDataService\Messengers\SendDataInterface;
use Src\SendDataService\Messengers\TelegramMessenger;

enum SendDataDetectionType: string
{
    case BY_EMAIL = MessageTypes::BY_EMAIL;
    case BY_TELEGRAM = MessageTypes::BY_TELEGRAM;

    public function detect(): SendDataInterface
    {
        return match ($this) {
            self::BY_EMAIL => new EmailMessenger(),
            self::BY_TELEGRAM => new TelegramMessenger()
        };
    }
}