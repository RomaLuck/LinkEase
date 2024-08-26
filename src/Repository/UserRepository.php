<?php

namespace Src\Repository;

use Src\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[] findAll()
 * @method User[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends EntityRepository
{
    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
