<?php

namespace Src\Security;

use Src\Database;
use Symfony\Component\HttpFoundation\Session\Session;

class Authenticator
{
    public function __construct(private Database $database, private Session $session)
    {
    }

    /**
     * @throws \Exception
     */
    public function authenticate($email, $password): bool
    {
        $user = $this->database->query('select * from users where email = :email', [
            'email' => $email
        ])->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $this->login(['id' => $user['id']]);

            return true;
        }

        return false;
    }

    public function login(array $user): void
    {
        $this->session->set('user', ['id' => $user['id']]);
    }

    public function logout(): void
    {
        $this->session->clear();
    }
}