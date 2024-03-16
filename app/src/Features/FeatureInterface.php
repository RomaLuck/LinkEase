<?php

namespace Src\Features;

use Doctrine\Common\Collections\ArrayCollection;

interface FeatureInterface
{
    public function getResponseCollection(): ArrayCollection;
}