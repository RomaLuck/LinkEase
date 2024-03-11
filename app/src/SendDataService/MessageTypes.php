<?php

namespace Src\SendDataService;

class MessageTypes
{
    public const BY_TELEGRAM = 'by_telegram';
    public const BY_EMAIL = 'by_email';

    public static function getAll(): array
    {
        return [
            self::BY_TELEGRAM,
            self::BY_EMAIL
        ];
    }
}