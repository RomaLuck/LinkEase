<?php

namespace Core;

use Core\Security\Authenticator;
use Core\Security\OAuthAuthenticator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\Reference;

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
        $this->register(Database::class, Database::class)
            ->addArgument('%db_url%')
            ->addArgument('%db_user%')
            ->addArgument('%db_password%');

        $this->register(Authenticator::class, Authenticator::class)
            ->addArgument(new Reference(Database::class));

        $this->register(OAuthAuthenticator::class, OAuthAuthenticator::class)
            ->addArgument('provider')
            ->addArgument(new Reference(Database::class))
            ->addArgument(new Reference(Authenticator::class));
    }

    private function registerParameters(): void
    {
        $this->setParameter('db_url', $_ENV['DATABASE_URL']);
        $this->setParameter('db_user', $_ENV['DB_USER']);
        $this->setParameter('db_password', $_ENV['DB_PASSWORD']);
    }
}