<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Form;

class SignInForm extends Form
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->add([
            'name'       => 'email',
            'type'       => Email::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign-in-form-email',
                'placeholder' => '',
            ],
            'options'    => [
                'label'                   => 'E-mail',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => Password::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign-in-form-password',
                'placeholder' => '',
            ],
            'options'    => [
                'label'                   => 'Password',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-outline-primary w-100',
            ],
            'options'    => [
                'label' => 'Sign in',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
