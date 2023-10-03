<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\CategoryController;
use Application\Controller\IndexController;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'factories' => [
        CategoryController::class => ReflectionBasedAbstractFactory::class,
        IndexController::class    => ReflectionBasedAbstractFactory::class,
    ],
];
