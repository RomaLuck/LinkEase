<?php

namespace Src\Http\Profile\Session;

use Src\Http\Controller;
use Src\Security\Authenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogInController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(Authenticator $authenticator, Request $request): Response
    {
        $form = new LogInForm($request->request);
        if ($form->isValid()) {
            $signedIn = $authenticator->authenticate(
                $form->get('email')->getData(),
                $form->get('password')->getData()
            );

            if (!$signedIn) {
                return $this->redirect('/', [
                    'warning' => 'No matching account found for that email address and password.'
                ]);
            }

            return $this->redirect('/', ['success' => 'You logged in successfully']);
        }

        return $this->redirect('/login', $form->getErrors());
    }
}