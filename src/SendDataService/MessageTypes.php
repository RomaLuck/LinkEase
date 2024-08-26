<?php

namespace Src\SendDataService;

class MessageTypes
{
    public const BY_TELEGRAM = 'telegram';
    public const BY_EMAIL = 'email';

    public static function getAll(): array
    {
        return [
            self::BY_TELEGRAM,
            self::BY_EMAIL
        ];
    }
}