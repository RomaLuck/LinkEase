<?php

namespace Src\Http\Profile\Registration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Src\Entity\Role;
use Src\Entity\User;
use Src\Http\Controller;
use Src\Queue\EmailQueueSenderCommand;
use Src\Queue\MessageQueueManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;

class RegistrationController extends Controller
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function __invoke(EntityManager $entityManager, Request $request): Response
    {
        $timezone = htmlspecialchars($request->request->get('selectedTimezone'));

        $form = new RegistrationForm($request->request);
        if ($form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
            if ($user) {
                return $this->redirect('/');
            }

            $user = new User();
            $user->setName($form->get('username')->getData())
                ->setEmail($email)
                ->setTimeZone($timezone)
                ->setPassword(password_hash($form->get('password')->getData(), PASSWORD_BCRYPT))
                ->setIsEmailConfirmed(false)
                ->setConfirmationToken(bin2hex(random_bytes(32)));

            $role = $entityManager->getRepository(Role::class)->findOneBy(['name' => 'user']);
            if ($role) {
                $user->setRole($role);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new Email())
                ->from($_ENV['EMAIL_SENDER'])
                ->to($user->getEmail())
                ->subject('Email Confirmation')
                ->html('<p>Please confirm your email by clicking the following link: <a href="http://localhost:8000/confirm-email?token=' . $user->getConfirmationToken() . '">Confirm Email</a></p>');

            (new MessageQueueManager())->enqueue(new EmailQueueSenderCommand($email));

            return $this->redirect('/', ['success' => 'Check your mailbox']);
        }

        return $this->redirect('/create', $form->getErrors());
    }
}
