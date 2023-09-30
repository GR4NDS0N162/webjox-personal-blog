<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\Helper\Form\FieldsetMapper;
use Application\Model\Options\RoleOptions;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;

class SignUpForm extends Form
{
    public const DEFAULT_LABEL_ATTRIBUTES = [
        'class' => 'form-label',
    ];

    private RoleOptions $roleOptions;

    /**
     * @param RoleOptions $roleOptions
     */
    public function __construct(RoleOptions $roleOptions)
    {
        parent::__construct();

        $this->roleOptions = $roleOptions;
    }

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
                'class'       => 'form-control',
                'placeholder' => 'name@example.com',
                'required'    => 'required',
                'pattern'     => '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',
            ],
            'options'    => [
                'label'            => 'E-mail',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
            ],
        ]);

        $this->add([
            'name'       => 'roleId',
            'type'       => Select::class,
            'attributes' => [
                'class'    => 'form-select',
                'required' => 'required',
            ],
            'options'    => [
                'label'            => 'Role',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
                'options'          => $this->roleOptions->getOptions(),
            ],
        ]);

        $this->add([
            'name'       => 'newPassword',
            'type'       => Password::class,
            'attributes' => [
                'class'        => 'form-control',
                'placeholder'  => 'qwerty123',
                'required'     => 'required',
                'autocomplete' => 'new-password',
                'minlength'    => 8,
                'maxlength'    => 32,
                'pattern'      => '^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!"#\$%&\'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~])[a-zA-Z0-9!"#\$%&\'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~]*$',
            ],
            'options'    => [
                'label'            => 'Password',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
            ],
        ]);

        $this->add([
            'name'       => 'passwordCheck',
            'type'       => Password::class,
            'attributes' => [
                'class'       => 'form-control',
                'placeholder' => 'qwerty123',
                'required'    => 'required',
                'pattern'     => '',
            ],
            'options'    => [
                'label'            => 'Password check',
                'label_attributes' => self::DEFAULT_LABEL_ATTRIBUTES,
            ],
        ]);

        $this->add([
            'name'       => 'submitButton',
            'type'       => Button::class,
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-outline-success w-100',
            ],
            'options'    => [
                'label' => 'Sign up',
            ],
        ], ['priority' => -10 ** 9]);

        FieldsetMapper::setAttributes($this, [
            'children' => [
                'email'         => 'col-12',
                'roleId'        => 'col-12',
                'newPassword'   => 'col-12',
                'passwordCheck' => 'col-12',
                'submitButton'  => 'col-12',
            ],
        ]);
    }
}
