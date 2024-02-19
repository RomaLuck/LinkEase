<?php

namespace Http\Controllers\profile;

use Core\Database;
use Core\FileUploader;
use Core\Session;
use Core\Validator;
use Http\Controllers\Controller;

class ProfileUpdateController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Database $db): void
    {
        $errors = [];

        try {
            $newEmail = htmlspecialchars($_POST['email']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $matchPassword = htmlspecialchars($_POST['match-password']);


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