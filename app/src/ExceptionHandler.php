<?php

namespace Src;

use Src\Database\EntityManagerFactory;
use Src\Entity\Exception;
use Src\Entity\Role;
use Src\Entity\User;
use Src\SendDataService\Messengers\TelegramMessenger;

class ExceptionHandler
{
    public static function handle($exception): void
    {
        $message = $exception->getMessage();
        $code = $exception->getCode();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $exceptionInfo =
            'message: ' . $message . "\n"
            . 'code: ' . $code . "\n"
            . 'file: ' . $file . "\n"
            . 'line: ' . $line . "\n"
            . 'time: ' . (new \DateTime('now', new \DateTimeZone('Europe/Warsaw')))
                ->format('H:i:s');

        $entityManager = EntityManagerFactory::create();

        $hash = md5($exceptionInfo);
        $existingHash = $entityManager->getRepository(Exception::class)->findOneBy(['hash' => $hash]);

        if ($existingHash === null) {
            $exception = new Exception();
            $exception->setMessage($message)
                ->setCode($code)
                ->setLine($line)
                ->setFile($file)
                ->setHash($hash);

            $entityManager->persist($exception);
            $entityManager->flush();

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
}