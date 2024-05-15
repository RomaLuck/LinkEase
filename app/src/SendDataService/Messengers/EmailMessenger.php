<?php

namespace Src\SendDataService\Messengers;

use Src\Entity\User;
use Src\Queue\EmailQueueSenderCommand;
use Src\Queue\MessageQueueManager;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;

class EmailMessenger implements SendDataInterface
{

    /**
     * @throws TransportExceptionInterface
     */
    public function send(User $user, string $message): void
    {
        $email = (new Email())
            ->from($_ENV['EMAIL_SENDER'])
            ->to($user->getEmail())
            ->subject('Your reminder!')
            ->html($message);

        (new MessageQueueManager())->enqueue(new EmailQueueSenderCommand($email));
    }
}