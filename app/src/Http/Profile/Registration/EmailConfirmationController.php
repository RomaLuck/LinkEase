<?php

namespace Src\Http\Profile\Registration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Src\Entity\User;
use Src\Http\Controller;
use Src\Security\Authenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailConfirmationController extends Controller
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function __invoke(EntityManager $entityManager, Request $request, Authenticator $authenticator): Response
    {
        $token = $request->query->get('token');

        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmation_token' => $token]);
        if (!$user) {
            return $this->redirect('/', ['error' => 'Invalid confirmation token']);
        }

        $user->setConfirmationToken(null)
            ->setIsEmailConfirmed(true);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirect('/', ['success' => 'Email has been confirmed successfully']);
    }
}