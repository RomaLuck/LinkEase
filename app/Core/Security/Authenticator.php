<?php

namespace Core\Security;

use Core\Database;
use Core\Session;

class Authenticator
{
    public function __construct(private Database $database)
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
        Session::put('user', ['id' => $user['id']]);

        session_regenerate_id(true);
    }

    public function logout(): void
    {
        session_destroy();
    }
}