<?php

namespace Src\Http\Profile\Session;

use JetBrains\PhpStorm\NoReturn;
use Src\Http\Controller;
use Src\Security\Authenticator;
use Src\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSessionCreateController extends Controller
{
    /**
     * @throws \Exception
     */
    #[NoReturn]
    public function __invoke(Authenticator $authenticator, Request $request): Response
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
            return $this->render('Profile.Session.create', ['errors' => $errors]);
        }

        return $this->redirect('/');
    }
}