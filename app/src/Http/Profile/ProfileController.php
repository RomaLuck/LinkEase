<?php

namespace Src\Http\Profile;

use Doctrine\ORM\EntityManager;
use Src\Entity\User;
use Src\Http\Controller;
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

        $this->render('Profile.profile', [
            'userData' => $userData ?? [],
            'errors' => $errors,
        ]);
    }
}