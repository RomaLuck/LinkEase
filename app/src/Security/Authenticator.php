<?php

namespace Src\Security;

use Doctrine\ORM\EntityManager;
use Src\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class Authenticator
{
    public function __construct(private EntityManager $entityManager, private Session $session)
    {
    }

    /**
     * @throws \Exception
     */
    public function authenticate($email, $password): bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneByEmail($email);
        if ($user && $user->isEmailConfirmed() && password_verify($password, $user->getPassword())) {
            $this->login(['id' => $user->getId()]);

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