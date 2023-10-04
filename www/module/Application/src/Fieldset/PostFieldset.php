<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Fieldset;

class PostFieldset extends Fieldset
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
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
