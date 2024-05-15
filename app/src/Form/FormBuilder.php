<?php

namespace Src\Form;

use Src\Validation\RuleInterface;
use Symfony\Component\HttpFoundation\InputBag;

class FormBuilder implements FormBuilderInterface
{
    private array $dataList = [];
    private InputBag $requestData;

    public function __construct(InputBag $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @param RuleInterface[] $rules
     */
    public function add(string $dataKey, array $rules): self
    {
        $dataValue = htmlspecialchars($this->requestData->get($dataKey));
        $this->dataList[$dataKey] = new FormRow($dataValue, $rules);

        return $this;
    }

    public function get(string $dataKey): FormRow
    {
        return $this->dataList[$dataKey];
    }

    public function getDataList(): array
    {
        return $this->dataList;
    }
}