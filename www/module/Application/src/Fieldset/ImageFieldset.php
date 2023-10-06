<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Collection;
use Laminas\Form\Fieldset;

class ImageFieldset extends Fieldset
{
    public const CONTAINER_ID = 'images_to_add-container';

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'row g-3');

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
        ], ['priority' => 10 ** 9]);

        $this->add([
            'name'       => 'images_to_add',
            'type'       => Collection::class,
            'attributes' => [
                'class' => 'row g-3',
                'id'    => self::CONTAINER_ID,
            ],
            'options'    => [
                'count'                  => 3,
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
    }
}
