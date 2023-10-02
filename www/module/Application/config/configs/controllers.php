<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\IndexController;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'factories' => [
        IndexController::class => ReflectionBasedAbstractFactory::class,
    ],
];
