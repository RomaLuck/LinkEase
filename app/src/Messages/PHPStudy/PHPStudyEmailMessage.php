<?php

namespace Src\Messages\PHPStudy;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Features\FeatureTypes;
use Src\Messages\MessageInterface;
use Src\SendDataService\MessageTypes;

class PHPStudyEmailMessage implements MessageInterface
{

    public function getMessage(ArrayCollection $data): string
    {
        $articleKey = random_int(1, $data->count());
        $article = $data->get($articleKey);

        $result = "<h4>$article->getTitle()</h4>";
        $result .= nl2br($article->getBody());

        return $result;
    }

    public function getFeature(): string
    {
        return FeatureTypes::PHP_STUDY;
    }

    public function getMessenger(): string
    {
        return MessageTypes::BY_EMAIL;
    }
}