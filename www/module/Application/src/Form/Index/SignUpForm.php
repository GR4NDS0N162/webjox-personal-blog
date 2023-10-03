<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Password;
use Laminas\Form\Form;

class SignUpForm extends Form
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

        $this->add([
            'name'       => 'user',
            'type'       => UserFieldset::class,
            'attributes' => [
                'id' => 'sign_up_form-user',
            ],
            'options'    => [
                FormRow::WRAPPER_CLASS => 'col-12',
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
