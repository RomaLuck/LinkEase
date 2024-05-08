<?php

namespace Src\Http\Features\Study;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Src\Entity\User;
use Src\Entity\UserSettings;
use Src\Features\Db\Study\PHPStudyFeature;
use Src\Features\FeatureTypes;
use Src\Http\Controller;
use Src\SendDataService\MessageTypes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class StudyDataController extends Controller
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws \Exception
     */
    public function __invoke(EntityManager $entityManager, Request $request, Session $session): Response
    {
        $time = $request->request->get('time-execute');
        $messageType = $request->request->get('message-type');
        $subject = $request->request->get('subject');
        $userId = $session->get('user')['id'];

        $user = $entityManager->getRepository(User::class)->findOneBy([
            'id' => $userId
        ]);

        if ($user === null) {
            return $this->redirect('/');
        }

        $userConfiguration = $entityManager
            ->getRepository(UserSettings::class)
            ->findOneBy(['user' => $user])
            ?? new UserSettings();

        $userConfiguration->setTime($this->convertToUtcTime($time, $user->getTimeZone()))
            ->setFeatureType($subject)
            ->setMessageType($messageType)
            ->setUser($user);

        $entityManager->persist($userConfiguration);
        $entityManager->flush();

        $article = (new PHPStudyFeature($entityManager))->getMessage();

        return $this->render('Features.Study.study', [
            'messageTypes' => MessageTypes::getAll(),
            'subjects' => FeatureTypes::getStudySubjects(),
            'article' => $article
        ]);
    }

    /**
     * @throws \Exception
     */
    private function convertToUtcTime(string $time, string $timeZoneName): \DateTime
    {
        $zoneUser = new \DateTimeZone($timeZoneName);
        $dateTimeUtc = new \DateTime($time, new \DateTimeZone('UTC'));
        $dateTimeUtc->modify('-' . $zoneUser->getOffset($dateTimeUtc) . ' seconds');

        return $dateTimeUtc;
    }
}