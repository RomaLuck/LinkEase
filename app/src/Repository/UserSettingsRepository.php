<?php

namespace Src\Repository;

use Src\Entity\UserSettings;
use Doctrine\ORM\EntityRepository;

/**
 * @method UserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSettings[] findAll()
 * @method UserSettings[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSettingsRepository extends EntityRepository
{
}
