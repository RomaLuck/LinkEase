<?php

namespace Src\Database;

use Doctrine\ORM\EntityManagerInterface;

class EntityManagerFactoryWrapper {
    private EntityManagerFactory $entityManagerFactory;

    public function __construct(EntityManagerFactory $entityManagerFactory) {
        $this->entityManagerFactory = $entityManagerFactory;
    }

    public function create(): EntityManagerInterface
    {
        return $this->entityManagerFactory::create();
    }
}
