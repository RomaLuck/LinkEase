<?php

namespace Src\SendDataService\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Features\FeatureTypes;
use Src\SendDataService\MessageTypes;

class PHPStudyMessage implements MessageInterface
{

    public function __construct(private ArrayCollection $data)
    {
    }

    public function getMessage(): string
    {
        $articleKey = random_int(1, $this->data->count() - 1);
        $article = $this->data->get($articleKey);

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