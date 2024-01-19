<?php

namespace Http\Controllers\registration;

use Core\Container;
use Core\Database;
use Core\Security\Authenticator;
use Core\Validator;
use Http\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;

class ProfileCreateController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Container $container): void
    {
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $matchPassword = htmlspecialchars($_POST['match-password']);

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

        $db = $container->get(Database::class);
        $user = $db?->query('select * from users where email = :email', [
            'email' => $email
        ])->fetch();
        if ($user) {
            redirect('/');
        }

        $db->query('INSERT INTO users(username, email, password) VALUES(:username, :email, :password)', [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        $container->get(Authenticator::class)?->login($user);

        redirect('/');
    }
}
