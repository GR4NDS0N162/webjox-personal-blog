<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Form;

class SignInForm extends Form
{
    public const DEFAULT_LABEL_ATTRIBUTES = [
        'class' => 'form-label',
    ];

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
                'required' => 'required',
            ],
            'options'    => [
                'label' => 'E-mail',
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => Password::class,
            'attributes' => [
                'required' => 'required',
            ],
            'options'    => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'type' => 'submit',
            ],
            'options'    => [
                'label' => 'Sign in',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
