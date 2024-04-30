<?php

namespace Src\Http\Profile\Registration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Src\Entity\User;
use Src\Http\Controller;
use Src\Queues\EmailQueueSenderCommand;
use Src\Queues\MessageQueueManager;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;

class ProfileCreateController extends Controller
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function __invoke(EntityManager $entityManager, Request $request): Response
    {
        $timezone = $request->request->get('selectedTimezone');
        $errors = [];

        $email = htmlspecialchars($request->request->get('email'));
        if (!Validator::email($email)) {
            $errors['email'] = 'Email is not valid';
        }

        $username = htmlspecialchars($request->request->get('username'));
        if (!Validator::string($username, 2, 255)) {
            $errors['username'] = 'The name must contain at least 2 characters';
        }

        $password = htmlspecialchars($request->request->get('password'));
        $matchPassword = htmlspecialchars($request->request->get('match-password'));
        if (!Validator::string($password, 5, 255) || !Validator::string($matchPassword, 5, 255)) {
            $errors['password'] = 'The password must contain at least 6 characters';
        }

        if (!Validator::matchPasswords($password, $matchPassword)) {
            $errors['match-password'] = 'The passwords do not match';
        }

        if (!empty($errors)) {
            return $this->render('Profile.Registration.create', ['errors' => $errors]);
        }

        $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
        if ($user) {
            return $this->redirect('/');
        }

        $user = new User();
        $user->setName($username)
            ->setEmail($email)
            ->setTimeZone($timezone)
            ->setPassword(password_hash($password, PASSWORD_BCRYPT))
            ->setIsEmailConfirmed(false)
            ->setConfirmationToken(bin2hex(random_bytes(32)));

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
}
