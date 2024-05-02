<?php

namespace Src\Features\Db\Study;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Src\Entity\StudyLibrary;
use Src\Features\FeatureInterface;
use Src\SendDataService\Messages\PHPStudyMessage;

class PHPStudyFeature implements FeatureInterface
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function getMessage(): string
    {
        return (new PHPStudyMessage($this->getDbData()))->getMessage();
    }

    private function getDbData(): ArrayCollection
    {
        $library = $this->entityManager->getRepository(StudyLibrary::class);

        return new ArrayCollection($library->findBy(['subject' => 'PHP']));
    }
}