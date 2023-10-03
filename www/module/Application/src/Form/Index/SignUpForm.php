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
    public function __construct(
        private RoleOptions $roleOptions,
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

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
                FormRow::WRAPPER_CLASS    => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'role_id',
            'type'       => Select::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-select',
                'id'       => 'sign_up_form-role_id',
            ],
            'options'    => [
                'label'                   => 'Role',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                FormRow::WRAPPER_CLASS    => 'col-12',
                'options'                 => $this->roleOptions->getOptions(),
            ],
        ]);

        $this->add([
            'name'       => 'password',
            'type'       => Password::class,
            'attributes' => [
                'required'     => 'required',
                'autocomplete' => 'new-password',
                'minlength'    => 8,
                'maxlength'    => 32,
                'class'        => 'form-control',
                'id'           => 'sign_up_form-password',
                'placeholder'  => '',
            ],
            'options'    => [
                'label'                   => 'Password',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                FormRow::WRAPPER_CLASS    => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'password_check',
            'type'       => Password::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign_up_form-password_check',
                'placeholder' => '',
            ],
            'options'    => [
                'label'                   => 'Password check',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                FormRow::WRAPPER_CLASS    => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-outline-success w-100',
                'id'    => 'sign_up_form-submit',
            ],
            'options'    => [
                'label'                => 'Sign up',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
