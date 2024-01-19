<?php

namespace Core\Security;

use Core\App;
use Core\Database;
use Core\Session;
use PDO;

class Authenticator
{
    /**
     * @throws \Exception
     */
    public function authenticate($email, $password): bool
    {
        /**
         * @var PDO $db
         */
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where email = :email', [
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