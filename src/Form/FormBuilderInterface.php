<?php

namespace Src\Form;

use Src\Validation\RuleInterface;

interface FormBuilderInterface
{
    /**
     * @param RuleInterface[] $rules
     */
    public function add(string $dataKey, array $rules);
}