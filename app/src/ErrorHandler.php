<?php

namespace Src;

use Src\Database\EntityManagerFactory;
use Src\Entity\Exception;
use Src\Entity\Role;
use Src\Entity\User;
use Src\SendDataService\Messengers\TelegramMessenger;

class ErrorHandler
{
    public static function handle($exception): void
    {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $exception = new Exception();
        $exception->setMessage($message)
            ->setCode($code)
            ->setLine($line)
            ->setFile($file);

        $entityManager = EntityManagerFactory::create();
        $entityManager->persist($exception);
        $entityManager->flush();

        $exceptionInfo = json_encode([
            'message' => $message,
            'code' => $code,
            'file' => $file,
            'line' => $line
        ]);

        $adminRole = $entityManager->getRepository(Role::class)->findOneBy(['name' => 'admin']);
        if ($adminRole === null) {
            return;
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['role' => $adminRole->getId()]);
        if ($user === null) {
            return;
        }

        $messenger = new TelegramMessenger();
        $messenger->send($user, $exceptionInfo);
    }
}