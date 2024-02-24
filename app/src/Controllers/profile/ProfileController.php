<?php

namespace Src\Controllers\profile;

use Doctrine\ORM\EntityManager;
use Src\Controllers\Controller;
use Src\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends Controller
{
    public function __invoke(EntityManager $entityManager, Session $session): void
    {
        $errors = [];

        try {
            $userData = $entityManager->getRepository(User::class)->findOneBy([
                'id' => $session->get('user')['id']
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->render('profile', [
            'userData' => $userData ?? [],
            'errors' => $errors,
        ]);
    }
}