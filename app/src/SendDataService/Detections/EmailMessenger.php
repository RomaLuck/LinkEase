<?php

namespace Src\SendDataService\Detections;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\User;
use Src\MailerFactory;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;

class EmailMessenger implements SendDataInterface
{

    /**
     * @throws TransportExceptionInterface
     */
    public function send(User $user, string $message): void
    {
        $mail = (new Email())
            ->from('example@example.com')
            ->to($user->getEmail())
            ->subject('Your reminder!')
            ->html($message);

        MailerFactory::getMailer()->send($mail);
    }
}