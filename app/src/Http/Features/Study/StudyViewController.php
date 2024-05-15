<?php

namespace Src\Http\Features\Study;

use Src\Feature\FeatureTypes;
use Src\Http\Controller;
use Src\SendDataService\MessageTypes;
use Symfony\Component\HttpFoundation\Response;

class StudyViewController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Features.Study.study', [
            'messageTypes' => MessageTypes::getAll(),
            'subjects' => FeatureTypes::getStudySubjects()
        ]);
    }
}