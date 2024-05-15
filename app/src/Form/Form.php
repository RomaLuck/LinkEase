<?php

namespace Src\Form;

use Symfony\Component\HttpFoundation\InputBag;

abstract class Form
{
    private array $errors = [];
    private FormBuilder $formBuilder;

    public function __construct(InputBag $requestData)
    {
        $this->formBuilder = new FormBuilder($requestData);
        $this->buildForm($this->formBuilder);
    }

    abstract public function buildForm(FormBuilderInterface $builder): void;

    public function get(string $dataKey): FormRow
    {
        return $this->formBuilder->get($dataKey);
    }

    public function isValid(): bool
    {
        foreach ($this->formBuilder->getDataList() as $dataKey => $dataValue) {
            foreach ($dataValue->getRules() as $rule) {
                if (!$rule->validate($dataValue->getData())) {
                    $this->errors[$dataKey] = $rule->getMessage($dataKey);
                }
            }
        }

        return $this->errors === [];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}