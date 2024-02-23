<?php

namespace Src;

use Doctrine\ORM\EntityManager;
use Src\Database\EntityManagerFactory;
use Src\Security\Authenticator;
use Src\Security\OAuthAuthenticator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Container extends ContainerBuilder
{
    public function __construct(ParameterBagInterface $parameterBag = null)
    {
        parent::__construct($parameterBag);
        $this->registerParameters();
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->register(EntityManager::class, EntityManagerFactory::class)
            ->setFactory([EntityManagerFactory::class, 'create']);

        $this->register(Session::class, Session::class);

        $this->register(Authenticator::class, Authenticator::class)
            ->addArgument(new Reference(EntityManager::class))
            ->addArgument(new Reference(Session::class));

        $this->register(OAuthAuthenticator::class, OAuthAuthenticator::class)
            ->addArgument(new Reference(EntityManager::class))
            ->addArgument(new Reference(Authenticator::class))
            ->addArgument(new Reference(Session::class));

        $this->register(Request::class, Request::class)
            ->setFactory([Request::class, 'createFromGlobals']);
    }

    private function registerParameters(): void
    {
    }
}