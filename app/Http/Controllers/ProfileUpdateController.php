<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;
use Core\FileUploader;
use Core\Session;
use Core\Validator;

class ProfileUpdateController extends Controller
{
    public function __invoke(): void
    {
        $errors = [];

        try {
            $newEmail = htmlspecialchars($_POST['email']);
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $matchPassword = htmlspecialchars($_POST['match-password']);
            $fileName = $_POST['file-name'] ?? '';
            if ($fileName !== '') {
                $fileName = FileUploader::upload('public/upload');
            }

            if (!Validator::email($newEmail)) {
                $errors[] = 'Email is not valid';
            }

            if (!Validator::string($username, 2, 255)) {
                $errors[] = 'The name must contain at least 2 characters';
            }

            if (!Validator::string($password, 5, 255) || !Validator::string($matchPassword, 5, 255)) {
                $errors[] = 'The password must contain at least 6 characters';
            }

            if (!Validator::matchPasswords($password, $matchPassword)) {
                $errors[] = 'The passwords do not match';
            }
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        if (!empty($errors)) {
            $this->redirect('profile', [
                'errors' => $errors,
            ]);
        }

        $db = App::resolve(Database::class);
        $db->query(
            'UPDATE users SET email = :email, username = :username, password = :password, file_path = :file_path WHERE id = :id',
            [
                'email' => $newEmail,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'file_path' => $fileName ?? '',
                'id' => Session::get('user')['id'],
            ]
        );
        $this->redirect('profile');
    }
}