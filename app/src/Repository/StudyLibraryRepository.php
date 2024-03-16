<?php

namespace Src\Repository;

use Src\Entity\StudyLibrary;
use Doctrine\ORM\EntityRepository;

/**
 * @method StudyLibrary|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyLibrary|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyLibrary[] findAll()
 * @method StudyLibrary[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyLibraryRepository extends EntityRepository
{
}
