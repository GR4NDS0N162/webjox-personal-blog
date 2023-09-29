<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Controller as Factory;

return [
    'factories' => [
        Controller\LoginController::class => Factory\LoginControllerFactory::class,
    ],
];
