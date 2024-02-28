<?php

namespace Src;

use Dotenv\Dotenv;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;

class TelegramBot extends Nutgram
{
    private Dotenv $dotenv;

    public function __construct(?Configuration $configuration = null)
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $this->dotenv->load();
        parent::__construct($_ENV['TELEGRAM_BOT_TOKEN'], $configuration);
    }
}