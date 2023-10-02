<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\Model\Options\RoleOptions;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Form;

class SignUpForm extends Form
{
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

        $this->add([
            'name'       => 'email',
            'type'       => Email::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign-up-form-email',
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
            'name'       => 'role-id',
            'type'       => Select::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-select',
                'id'       => 'sign-up-form-role-id',
            ],
            'options'    => [
                'label'                   => 'Role',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                'options'                 => $this->roleOptions->getOptions(),
            ],
        ]);

        $this->add([
            'name'       => 'new-password',
            'type'       => Password::class,
            'attributes' => [
                'required'     => 'required',
                'autocomplete' => 'new-password',
                'minlength'    => 8,
                'maxlength'    => 32,
                'class'        => 'form-control',
                'id'           => 'sign-up-form-new-password',
                'placeholder'  => '',
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
            'name'       => 'password-check',
            'type'       => Password::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign-up-form-password-check',
                'placeholder' => '',
            ],
            'options'    => [
                'label'                   => 'Password check',
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
                'class' => 'btn btn-lg btn-outline-success w-100',
            ],
            'options'    => [
                'label' => 'Sign up',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
