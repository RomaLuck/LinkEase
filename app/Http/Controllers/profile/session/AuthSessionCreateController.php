<?php

namespace Http\Controllers\profile\session;

use Core\Security\Authenticator;
use Core\Validator;
use Http\Controllers\Controller;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Request;

class AuthSessionCreateController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Authenticator $authenticator, Request $request): void
    {
        $email = htmlspecialchars($request->request->get('email'));
        $password = htmlspecialchars($request->request->get('password'));

        $errors = [];

        if (!Validator::email($email)) {
            $errors['email'] = 'Email is not valid';
        }

        if (!Validator::string($password, 6, 255)) {
            $errors['password'] = 'The password must contain at least 6 characters';
        }

        $signedIn = $authenticator->authenticate($email, $password);
        if (!$signedIn) {
            $errors['signedIn'] = 'No matching account found for that email address and password.';
        }

        if (!empty($errors)) {
            $this->render('session/create.view.php', ['errors' => $errors]);
            exit();
        }

        $this->redirect('/');
    }
}