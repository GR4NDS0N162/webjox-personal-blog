<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\Helper\Form\FieldsetMapper;
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

        $this->setAttribute('class', 'row gy-3 needs-validation');
        $this->setAttribute('novalidate', true);

        $this->add([
            'name'       => 'email',
            'type'       => Email::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-control',
            ],
            'options'    => [
                'label'            => 'E-mail',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => Password::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-control',
            ],
            'options'    => [
                'label'            => 'Password',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-outline-success w-100',
            ],
            'options'    => [
                'label' => 'Sign in',
            ],
        ], ['priority' => -10 ** 9]);

        FieldsetMapper::setAttributes($this, [
            'children' => [
                'email'    => 'col-12',
                'password' => 'col-12',
                'submit'   => 'col-12',
            ],
        ]);
    }
}
