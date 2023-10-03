<?php

declare(strict_types=1);

namespace Application;

use Application\Form\Index\SignUpForm;
use Application\Form\Index\UserFieldset;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        UserFieldset::class => ReflectionBasedAbstractFactory::class,
        SignUpForm::class   => ReflectionBasedAbstractFactory::class,
    ],
];
