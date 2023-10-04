<?php

declare(strict_types=1);

namespace Application\Form\Post;

use Application\Fieldset\PostFieldset;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Form;

class PostForm extends Form
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
}
