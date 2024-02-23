<?php

namespace Src\Controllers\profile\registration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Src\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;
use Src\Entity\User;
use Src\Security\Authenticator;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;

class ProfileCreateController extends Controller
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(EntityManager $entityManager, Authenticator $authenticator, Request $request): void
    {
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
            $this->render('registration/create.view.php', ['errors' => $errors]);
            exit();
        }

        $user = $entityManager->getRepository(User::class)->findOneByEmail($email);
        if ($user) {
            $this->redirect('/');
        }

        $user = new User();
        $user->setName($username)
            ->setEmail($email)
            ->setPassword(password_hash($password, PASSWORD_BCRYPT));

        $entityManager->persist($user);
        $entityManager->flush();

        $authenticator->authenticate($email, $password);

        $this->redirect('/', ['success' => 'User has been registered successfully']);
    }
}
