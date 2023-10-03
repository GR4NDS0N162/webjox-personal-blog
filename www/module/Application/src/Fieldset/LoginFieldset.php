<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Fieldset;

class LoginFieldset extends Fieldset
{
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
            'name'       => 'password',
            'type'       => Password::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'sign_up_form-password',
                'placeholder' => '',
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
    }
}
