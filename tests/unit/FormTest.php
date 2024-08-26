<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use Src\Form\Form;
use Src\Form\FormRow;
use Src\Http\Contact\ContactForm;
use Src\Validation\RuleInterface;
use Symfony\Component\HttpFoundation\InputBag;

class FormTest extends TestCase
{
    private Form $form;

    protected function setUp(): void
    {
        $requestData = new InputBag(['name' => 'Roman']);
        $this->form = new ContactForm($requestData);
    }

    public function testIsValidReturnsTrueWhenAreErrors(): void
    {
        $this->assertFalse($this->form->isValid());
    }

    public function testGetErrorsReturnsEmptyArrayWhenNoErrors(): void
    {
        $this->assertSame([], $this->form->getErrors());
    }

    public function testGetErrorsReturnsErrorMessagesWhenThereAreErrors(): void
    {
        // Add a rule that will fail
        $this->form->get('name')->addRule(new class implements RuleInterface {
            public function validate($value): bool
            {
                return false;
            }

            public function getMessage($value): string
            {
                return 'Error message';
            }
        });

        $this->form->isValid();

        $expectedArray = [
            'name' => 'Error message',
            'email' => 'The email is not valid',
            'message' => 'The message must contain at least 6 characters and maximum 1000 characters'
        ];

        $this->assertSame($expectedArray, $this->form->getErrors());
    }

    public function testGetReturnsFormRowForGivenDataKey(): void
    {
        $formRow = $this->form->get('name');

        $this->assertInstanceOf(FormRow::class, $formRow);
        $this->assertSame('Roman', $formRow->getData());
    }
}