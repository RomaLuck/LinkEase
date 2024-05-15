<?php

namespace Src\Form;

use Src\Validation\RuleInterface;

class FormRow
{
    private string $data;

    /**
     * @var RuleInterface[]
     */
    private array $rules;

    public function __construct(string $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }


    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}