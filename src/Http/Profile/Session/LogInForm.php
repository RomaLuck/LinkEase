<?php

namespace Src\Http\Profile\Session;

use Src\Form\Form;
use Src\Form\FormBuilderInterface;
use Src\Validation\EmailRule;
use Src\Validation\StringLengthRule;

class LogInForm extends Form
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder
            ->add('email', [new EmailRule()])
            ->add('password', [new StringLengthRule(6, 255)]);
    }
}