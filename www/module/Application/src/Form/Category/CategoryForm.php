<?php

declare(strict_types=1);

namespace Application\Form\Category;

use Application\Fieldset\CategoryFieldset;
use Application\View\Helper\FormRow;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Collection;
use Laminas\Form\Form;

class CategoryForm extends Form
{
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
                'class' => 'btn btn-lg btn-outline-primary w-100',
                'id'    => 'category_form-add',
            ],
            'options'    => [
                'label'                => 'Add',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ], ['priority' => 10 ** 9]);

        $this->add([
            'name'       => 'list',
            'type'       => Collection::class,
            'attributes' => [
                'class' => 'row g-3',
            ],
            'options'    => [
                'count'                  => 3,
                'allow_add'              => true,
                'allow_remove'           => true,
                'should_create_template' => true,
                'template_placeholder'   => '__index__',
                'target_element'         => [
                    'type' => CategoryFieldset::class,
                ],
                FormRow::WRAPPER_CLASS   => 'col-12',
            ],
        ]);

        $this->add([
            'name'       => 'submit',
            'type'       => Button::class,
            'attributes' => [
                'type'  => 'submit',
                'class' => 'btn btn-lg btn-outline-success w-100',
                'id'    => 'category_form-submit',
            ],
            'options'    => [
                'label'                => 'Save',
                FormRow::WRAPPER_CLASS => 'col-12',
            ],
        ], ['priority' => -10 ** 9]);
    }
}
