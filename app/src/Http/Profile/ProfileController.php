<?php

namespace Src\Http\Profile;

use Doctrine\ORM\EntityManager;
use Src\Entity\User;
use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfileController extends Controller
{
    public function __invoke(EntityManager $entityManager, Session $session): Response
    {
        $errors = [];

        try {
            $userData = $entityManager->getRepository(User::class)->findOneBy([
                'id' => $session->get('user')['id']
            ]);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        return $this->render('Profile.profile', [
            'userData' => $userData ?? [],
            'errors' => $errors,
        ]);
    }
}