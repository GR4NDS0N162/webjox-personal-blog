<?php

declare(strict_types=1);

namespace Application\Form\Post;

use Application\Fieldset\ImageFieldset;
use Application\Fieldset\PostFieldset;
use Application\View\Helper\FormMultiCheckbox;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterProviderInterface;

class PostForm extends Form implements InputFilterProviderInterface
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

        $this->add([
            'name'       => 'post',
            'type'       => PostFieldset::class,
            'attributes' => [
                'id' => 'post_form-post',
            ],
            'options'    => [
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'categories',
            'type'       => MultiCheckbox::class,
            'attributes' => [
                'class' => 'form-check-input',
            ],
            'options'    => [
                'label'                                  => 'Categories',
                'label_attributes'                       => [
                    'class' => 'form-check-label',
                ],
                FormRow::WRAPPER_CLASS                   => 'col-12',
                FormMultiCheckbox::OPTIONS_WRAPPER_CLASS => 'row g-3',
                FormMultiCheckbox::OPTION_WRAPPER_CLASS  => 'col-12 col-md-6 col-xl-4',
                FormMultiCheckbox::INPUT_WRAPPER_CLASS   => 'form-check',
            ],
        ]);

        $this->add([
            'name'       => 'images',
            'type'       => ImageFieldset::class,
            'attributes' => [
                'id' => 'post_form-images',
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
                'class' => 'btn btn-lg btn-outline-success w-100',
            ],
            'options'    => [
                'label'                => 'Save',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ], ['priority' => -10 ** 9]);
    }

    /**
     * @inheritDoc
     */
    public function getInputFilterSpecification(): array
    {
        return [
            [
                'name'        => 'categories',
                'allow_empty' => true,
                'filters'     => [
                ],
                'validators'  => [
                ],
            ],
        ];
    }
}
