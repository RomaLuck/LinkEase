<?php

namespace Src\Controllers\profile;

use Src\Controllers\Controller;
use Src\Database;
use Src\FileUploader;
use Src\Session;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;

class ProfileUpdateController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Database $db, Request $request): void
    {
        $errors = [];

        try {
            $newEmail = htmlspecialchars($request->request->get('email'));
            $username = htmlspecialchars($request->request->get('username'));
            $password = htmlspecialchars($request->request->get('password'));
            $matchPassword = htmlspecialchars($request->request->get('match-password'));


            $fileName = $_FILES['upfile']['name'] ?? '';
            if ($fileName !== '') {
                $fileName = FileUploader::upload('public/uploads');

                $db->query(
                    'UPDATE users SET file_path = :file_path WHERE id = :id',
                    [
                        'file_path' => $fileName,
                        'id' => Session::get('user')['id'],
                    ]
                );
            }

            if (!Validator::email($newEmail)) {
                $errors['danger'] = 'Email is not valid';
            }

            if (!Validator::string($username, 2, 255)) {
                $errors['danger'] = 'The name must contain at least 2 characters';
            }

            if (!Validator::string($password, 5, 255) || !Validator::string($matchPassword, 5, 255)) {
                $errors['danger'] = 'The password must contain at least 6 characters';
            }

            if (!Validator::matchPasswords($password, $matchPassword)) {
                $errors['danger'] = 'The passwords do not match';
            }
        } catch (\RuntimeException $e) {
            $errors['danger'] = $e->getMessage();
        }

        if (!empty($errors)) {
            $this->redirect('profile', [
                'errors' => $errors,
            ]);
        }

        $db->query(
            'UPDATE users SET email = :email, username = :username, password = :password WHERE id = :id',
            [
                'email' => $newEmail,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'id' => Session::get('user')['id'],
            ]
        );

        $this->redirect('profile', ['success' => 'Profile has been updated successfully']);
    }
}