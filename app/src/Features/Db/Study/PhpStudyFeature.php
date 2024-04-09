<?php

namespace Src\Features\Db\Study;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Src\Entity\StudyLibrary;
use Src\Features\FeatureInterface;

class PhpStudyFeature implements FeatureInterface
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function getData(): ArrayCollection
    {
        $library = $this->entityManager->getRepository(StudyLibrary::class);

        return new ArrayCollection($library->findBy(['subject' => 'PHP']));
    }
}