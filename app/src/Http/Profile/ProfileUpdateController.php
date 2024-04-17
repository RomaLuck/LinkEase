<?php

namespace Src\Http\Profile;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Src\Entity\User;
use Src\FileUploader;
use Src\Http\Controller;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileUpdateController extends Controller
{
    /**
     * @throws \Exception
     * @throws ORMException
     */
    public function __invoke(EntityManager $entityManager, Request $request, Session $session): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy([
            'id' => $session->get('user')['id']
        ]);

        if ($user === null) {
            return $this->redirect('/');
        }

        $errors = [];

        $newEmail = htmlspecialchars($request->request->get('email'));
        if ($newEmail !== '') {
            if (!Validator::email($newEmail)) {
                $errors['danger'] = 'Email is not valid';
            }
            $user->setEmail($newEmail);
        }

        $username = htmlspecialchars($request->request->get('username'));
        if ($username !== '') {
            if (!Validator::string($username, 2, 255)) {
                $errors['danger'] = 'The name must contain at least 2 characters';
            }
            $user->setName($username);
        }

        $password = htmlspecialchars($request->request->get('password'));
        $matchPassword = htmlspecialchars($request->request->get('match-password'));
        if ($password !== '' && $matchPassword !== '') {
            if (!Validator::string($password, 5, 255) || !Validator::string($matchPassword, 5, 255)) {
                $errors['danger'] = 'The password must contain at least 6 characters';
            }

            if (!Validator::matchPasswords($password, $matchPassword)) {
                $errors['danger'] = 'The passwords do not match';
            }
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        }

        $timezone = $request->request->get('selectedTimezone');
        if ($timezone !== null) {
            $user->setName(htmlspecialchars($timezone));
        }

        $fileName = $_FILES['upfile']['name'] ?? '';
        if ($fileName !== '') {
            $fileName = FileUploader::upload('public/uploads');

            $user->setImagePath($fileName);
        }

        if (!empty($errors)) {
            return $this->redirect('profile', $errors);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirect('profile', ['success' => 'Profile has been updated successfully']);
    }
}