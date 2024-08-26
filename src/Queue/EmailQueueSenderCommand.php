<?php

namespace Src\Queue;

use Src\MailerFactory;
use Symfony\Component\Mime\Email;

class EmailQueueSenderCommand implements QueueSenderCommandInterface
{
    private Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function execute(): void
    {
        MailerFactory::getMailer()->send($this->email);
    }
}