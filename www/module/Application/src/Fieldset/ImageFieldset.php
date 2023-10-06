<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\View\Helper\FormMultiCheckbox;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;

class ImageFieldset extends Fieldset implements InputFilterProviderInterface
{
    public const CONTAINER_ID = 'images_to_add-container';
    public const REMOVE_CONTAINER_ID = 'images_to_remove-container';

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

        $this->add([
            'name'       => 'images_to_remove',
            'type'       => MultiCheckbox::class,
            'attributes' => [
                'class' => 'form-check-input',
            ],
            'options'    => [
                'label'                                  => 'Images to remove',
                'label_attributes'                       => [
                    'class' => 'form-check-label',
                ],
                'label_options'                          => [
                    'disable_html_escape' => true,
                ],
                FormRow::WRAPPER_CLASS                   => 'col-12',
                FormMultiCheckbox::OPTIONS_WRAPPER_CLASS => 'row g-3',
                FormMultiCheckbox::OPTION_WRAPPER_CLASS  => 'col-auto',
                FormMultiCheckbox::INPUT_WRAPPER_CLASS   => 'form-check',
            ],
        ]);

        $this->add([
            'name'       => 'images_to_add',
            'type'       => Collection::class,
            'attributes' => [
                'class' => 'row g-3',
                'id'    => self::CONTAINER_ID,
            ],
            'options'    => [
                'label'                  => 'Images to add',
                'count'                  => 0,
                'allow_add'              => true,
                'allow_remove'           => true,
                'should_create_template' => true,
                'template_placeholder'   => '__index__',
                'target_element'         => [
                    'type'    => ImageToAddFieldset::class,
                    'options' => [
                        FormRow::WRAPPER_CLASS => 'col-12 col-lg-6',
                    ],
                ],
                FormRow::WRAPPER_CLASS   => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'add',
            'type'       => Button::class,
            'attributes' => [
                'class'             => 'btn btn-lg btn-outline-primary w-100',
                'id'                => 'image_fieldset-add',
                'onclick'           => 'add_item(this)',
                'data-container-id' => self::CONTAINER_ID,
            ],
            'options'    => [
                'label'                => 'Add',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getInputFilterSpecification(): array
    {
        return [
            [
                'name'        => 'images_to_remove',
                'allow_empty' => true,
                'filters'     => [
                ],
                'validators'  => [
                ],
            ],
        ];
    }
}
