<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\Model\Options\StatusOptions;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Fieldset;

class PostFieldset extends Fieldset
{
    /**
     * @inheritDoc
     */
    public function __construct(
        private StatusOptions $statusOptions,
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
            'name'       => 'status_id',
            'type'       => Select::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-select',
                'id'       => 'post_form-status_id',
            ],
            'options'    => [
                'label'                   => 'Status',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                FormRow::WRAPPER_CLASS    => 'col-12',
                'options'                 => $this->statusOptions->getOptions(),
            ],
        ]);

        $this->add([
            'name'       => 'content',
            'type'       => Textarea::class,
            'attributes' => [
                'required'    => 'required',
                'class'       => 'form-control',
                'id'          => 'post_form-content',
                'placeholder' => '',
            ],
            'options'    => [
                'label'                   => 'Content',
                'label_attributes'        => [
                    'class' => 'form-label',
                ],
                FormRow::FLOATING_ENABLED => true,
                FormRow::WRAPPER_CLASS    => 'col-12',
            ],
        ]);
    }
}
