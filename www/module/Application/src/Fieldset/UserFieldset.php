<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\Model\Options\RoleOptions;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Fieldset;

class UserFieldset extends Fieldset
{
    public function __construct(
        private RoleOptions $roleOptions,
        $name = null,
        array $options = [],
    ) {
        parent::__construct($name, $options);
    }

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);

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
    }
}
