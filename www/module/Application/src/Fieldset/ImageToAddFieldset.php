<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\File;
use Laminas\Form\Fieldset;

class ImageToAddFieldset extends Fieldset
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'input-group');

        $this->add([
            'name'       => 'image',
            'type'       => File::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'delete',
            'type'       => Button::class,
            'attributes' => [
                'class'             => 'btn btn-outline-danger',
                'onclick'           => 'delete_item(this)',
                'data-container-id' => ImageFieldset::CONTAINER_ID,
            ],
            'options'    => [
                'label'         => '<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs>' .
                    '<style>.cls-1{fill:none;stroke:currentColor;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px}' .
                    '</style></defs><title></title><g id="cross"><line class="cls-1" x1="7" x2="25" y1="7" y2="25"></line>' .
                    '<line class="cls-1" x1="7" x2="25" y1="25" y2="7"></line></g></svg>',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
        ]);
    }
}
