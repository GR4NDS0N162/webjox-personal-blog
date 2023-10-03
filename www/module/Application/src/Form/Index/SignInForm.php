<?php

declare(strict_types=1);

namespace Application\Form\Index;

use Application\Fieldset\LoginFieldset;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Form;

class SignInForm extends Form
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
            'type'       => LoginFieldset::class,
            'attributes' => [
                'id' => 'sign_in_form-user',
            ],
            'options'    => [
                FormRow::WRAPPER_CLASS => 'col-12',
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
                'label'                => 'Sign in',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
