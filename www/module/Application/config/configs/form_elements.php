<?php

namespace Application;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        Form\Index\SignUpForm::class => InvokableFactory::class,
    ],
];
