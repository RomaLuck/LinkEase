<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Src\Form\Form;
use Src\Validation\RuleInterface;
use Symfony\Component\HttpFoundation\InputBag;

class FormTest extends TestCase
{
    private $form;

    protected function setUp(): void
    {
        $requestData = new InputBag(['field' => 'value']);
        $this->form = $this->getMockBuilder(Form::class)
            ->setConstructorArgs([$requestData])
            ->getMockForAbstractClass();
    }

    public function testIsValidReturnsTrueWhenNoErrors(): void
    {
        $this->assertTrue($this->form->isValid());
    }

    public function testIsValidReturnsFalseWhenThereAreErrors(): void
    {
        // Add a rule that will fail
        $this->form->get('field')->addRule(new class implements RuleInterface {
            public function validate($value): bool { return false; }
            public function getMessage($value): string { return 'Error message'; }
        });

        $this->assertFalse($this->form->isValid());
    }

    public function testGetErrorsReturnsEmptyArrayWhenNoErrors(): void
    {
        $this->assertSame([], $this->form->getErrors());
    }

    public function testGetErrorsReturnsErrorMessagesWhenThereAreErrors(): void
    {
        // Add a rule that will fail
        $this->form->get('field')->addRule(new class implements RuleInterface {
            public function validate($value): bool { return false; }
            public function getMessage($value): string { return 'Error message'; }
        });

        $this->form->isValid();

        $this->assertSame(['field' => 'Error message'], $this->form->getErrors());
    }

    public function testGetReturnsFormRowForGivenDataKey(): void
    {
        $formRow = $this->form->get('field');

        $this->assertInstanceOf(FormRow::class, $formRow);
        $this->assertSame('value', $formRow->getData());
    }
}