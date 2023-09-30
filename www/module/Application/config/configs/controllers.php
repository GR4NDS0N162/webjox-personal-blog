<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Controller as Factory;

return [
    'factories' => [
        Controller\IndexController::class => Factory\IndexControllerFactory::class,
    ],
];
