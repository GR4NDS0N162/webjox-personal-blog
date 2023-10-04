<?php

declare(strict_types=1);

namespace Application;

use Application\View\Helper\FormCollection;
use Application\View\Helper\FormMultiCheckbox;
use Application\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'aliases'   => [
        'formmulticheckbox'   => FormMultiCheckbox::class,
        'form_multi_checkbox' => FormMultiCheckbox::class,
        'formMultiCheckbox'   => FormMultiCheckbox::class,
        'FormMultiCheckbox'   => FormMultiCheckbox::class,
        'formcollection'      => FormCollection::class,
        'form_collection'     => FormCollection::class,
        'formCollection'      => FormCollection::class,
        'FormCollection'      => FormCollection::class,
        'formrow'             => FormRow::class,
        'form_row'            => FormRow::class,
        'formRow'             => FormRow::class,
        'FormRow'             => FormRow::class,
    ],
    'factories' => [
        FormCollection::class => InvokableFactory::class,
        FormRow::class        => InvokableFactory::class,
    ],
];
