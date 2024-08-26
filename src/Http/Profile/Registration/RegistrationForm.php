<?php

namespace Src\Http\Profile\Registration;

use Src\Form\Form;
use Src\Form\FormBuilderInterface;
use Src\Validation\EmailRule;
use Src\Validation\MatchPasswordsRule;
use Src\Validation\StringLengthRule;

class RegistrationForm extends Form
{

    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder
            ->add('email', [new EmailRule()])
            ->add('username', [new StringLengthRule(2, 255)])
            ->add('password', [new StringLengthRule(2, 255)])
            ->add('match-password', [
                new StringLengthRule(2, 255),
                new MatchPasswordsRule($builder->get('password')->getData())
            ]);
    }
}