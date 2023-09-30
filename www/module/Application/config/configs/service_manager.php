<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Options as OptionsFactory;
use Application\Model\Options as Options;

return [
    'aliases'   => [
    ],
    'factories' => [
        Options\RoleOptions::class => OptionsFactory\RoleOptionsFactory::class,
    ],
];
