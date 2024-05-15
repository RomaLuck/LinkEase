<?php

namespace Src\Http\Contact;

use Src\Form\Form;
use Src\Form\FormBuilderInterface;
use Src\Validation\EmailRule;
use Src\Validation\StringLengthRule;

class ContactForm extends Form
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder
            ->add('name', [new StringLengthRule(2, 255)])
            ->add('email', [new EmailRule()])
            ->add('message', [new StringLengthRule(6, 1000)]);
    }
}