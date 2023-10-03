<?php

declare(strict_types=1);

namespace Application\Form\Post;

use Application\View\Helper\FormRow;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Textarea;
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
