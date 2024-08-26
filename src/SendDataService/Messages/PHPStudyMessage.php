<?php

namespace Src\SendDataService\Messages;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\StudyLibrary;

class PHPStudyMessage implements MessageInterface
{

    public function __construct(private ArrayCollection $data)
    {
    }

    public function getMessage(): string
    {
        $articleKey = random_int(1, $this->data->count() - 1);

        /** @var StudyLibrary $article */
        $article = $this->data->get($articleKey);

        $result = "<h4>{$article->getTitle()}</h4>";
        $result .= nl2br($article->getBody());

        return $result;
    }
}