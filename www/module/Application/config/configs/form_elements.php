<?php

declare(strict_types=1);

namespace Application;

use Application\Form\Index\SignUpForm;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        SignUpForm::class => ReflectionBasedAbstractFactory::class,
    ],
];
