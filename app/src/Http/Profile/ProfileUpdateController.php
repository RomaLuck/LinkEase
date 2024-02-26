<?php

namespace Src\Http\Profile;

use Doctrine\ORM\EntityManager;
use JetBrains\PhpStorm\NoReturn;
use Src\Entity\User;
use Src\FileUploader;
use Src\Http\Controller;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileUpdateController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(EntityManager $entityManager, Request $request, Session $session): void
    {
        $errors = [];

        $newEmail = htmlspecialchars($request->request->get('email'));
        if (!Validator::email($newEmail)) {
            $errors['danger'] = 'Email is not valid';
        }

        $username = htmlspecialchars($request->request->get('username'));
        if (!Validator::string($username, 2, 255)) {
            $errors['danger'] = 'The name must contain at least 2 characters';
        }

        $password = htmlspecialchars($request->request->get('password'));
        $matchPassword = htmlspecialchars($request->request->get('match-password'));
        if (!Validator::string($password, 5, 255) || !Validator::string($matchPassword, 5, 255)) {
            $errors['danger'] = 'The password must contain at least 6 characters';
        }

        if (!Validator::matchPasswords($password, $matchPassword)) {
            $errors['danger'] = 'The passwords do not match';
        }

        if (!empty($errors)) {
            $this->redirect('profile', $errors);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy([
            'id' => $session->get('user')['id']
        ]);

        if ($user === null) {
            $this->redirect('/');
        }

        $user->setEmail($newEmail)
            ->setName($username)
            ->setPassword(password_hash($password, PASSWORD_BCRYPT));

        $fileName = $_FILES['upfile']['name'] ?? '';
        if ($fileName !== '') {
            $fileName = FileUploader::upload('public/uploads');

            $user->setImagePath($fileName);
        }

        $this->redirect('profile', ['success' => 'Profile has been updated successfully']);
    }
}