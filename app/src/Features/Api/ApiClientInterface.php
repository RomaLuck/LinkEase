<?php

namespace Src\Features\Api;

use Doctrine\Common\Collections\ArrayCollection;

interface ApiClientInterface
{
    public function getResponseCollection(): ArrayCollection;
}