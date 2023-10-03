<?php

declare(strict_types=1);

namespace Application\Fieldset;

use Laminas\Form\Element\Button;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;

class CategoryFieldset extends Fieldset
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setAttribute('class', 'input-group');

        $this->add([
            'name'       => 'name',
            'type'       => Text::class,
            'attributes' => [
                'required' => 'required',
                'class'    => 'form-control',
            ],
        ]);

        $this->add([
            'name' => 'id',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name'       => 'delete',
            'type'       => Button::class,
            'attributes' => [
                'class' => 'btn btn-outline-danger',
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
