<?php

namespace Src;

use Dotenv\Dotenv;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

class MailerFactory
{
    public static function getMailer(): Mailer
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $transport = Transport::fromDsn($_ENV['MAILER_SMTPS']);
        return new Mailer($transport);
    }
}