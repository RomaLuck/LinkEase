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
    public function findSettingsBetweenTimes(\DateTimeInterface $currentTime, \DateTimeInterface $maxTime)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.time > :time')
            ->setParameter('time', $currentTime)
            ->andWhere('u.time < :max_time')
            ->setParameter('max_time', $maxTime)
            ->getQuery()
            ->getResult();
    }
}
