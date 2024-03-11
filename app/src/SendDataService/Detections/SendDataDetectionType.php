<?php

namespace Src\SendDataService\Detections;

enum SendDataDetectionType: string
{
    case BY_EMAIL = 'by_email';
    case BY_TELEGRAM = 'by_telegram';

    public function detect(): SendDataInterface
    {
        return match ($this) {
            self::BY_EMAIL => new SendByEmail(),
            self::BY_TELEGRAM => new SendByTelegram()
        };
    }
}