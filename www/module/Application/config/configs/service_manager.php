<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Options as OptionsFactory;
use Application\Factory\Repository as RepositoryFactory;
use Application\Model\Options as Options;
use Application\Model\Repository as Repository;

return [
    'aliases'   => [
        Repository\RoleRepositoryInterface::class => Repository\RoleRepository::class,
    ],
    'factories' => [
        Options\RoleOptions::class       => OptionsFactory\RoleOptionsFactory::class,
        Repository\RoleRepository::class => RepositoryFactory\RoleRepositoryFactory::class,
        Repository\UserRepository::class => RepositoryFactory\UserRepositoryFactory::class,
    ],
];
