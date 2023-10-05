<?php

declare(strict_types=1);

namespace Application;

use Application\Fieldset\PostFieldset;
use Application\Fieldset\UserFieldset;
use Application\Form\Index\SignUpForm;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'aliases'   => [
    ],
    'factories' => [
        UserFieldset::class => ReflectionBasedAbstractFactory::class,
        PostFieldset::class => ReflectionBasedAbstractFactory::class,
        SignUpForm::class   => ReflectionBasedAbstractFactory::class,
    ],
];
