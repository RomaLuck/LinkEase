<?php

namespace Src\Controllers\profile\registration;

use Src\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;
use Src\Database;
use Src\Security\Authenticator;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;

class ProfileCreateController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Database $db, Authenticator $authenticator, Request $request): void
    {
        $email = htmlspecialchars($request->request->get('email'));
        $username = htmlspecialchars($request->request->get('username'));
        $password = htmlspecialchars($request->request->get('password'));
        $matchPassword = htmlspecialchars($request->request->get('match-password'));

        $errors = [];

        if (!Validator::email($email)) {
            $errors['email'] = 'Email is not valid';
        }

        if (!Validator::string($username, 2, 255)) {
            $errors['username'] = 'The name must contain at least 2 characters';
        }

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

        $user = $db?->query('select * from users where email = :email', [
            'email' => $email
        ])->fetch();
        if ($user) {
            $this->redirect('/');
        }

        $db->query('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)', [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        $authenticator->authenticate($email, $password);

        $this->redirect('/', ['success' => 'User has been registered successfully']);
    }
}
