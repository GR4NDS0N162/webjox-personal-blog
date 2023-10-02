<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Command as CommandFactory;
use Application\Factory\Options as OptionsFactory;
use Application\Factory\Repository as RepositoryFactory;
use Application\Model\Command as Command;
use Application\Model\Options as Options;
use Application\Model\Repository as Repository;

return [
    'aliases'   => [
        Command\UserCommandInterface::class => Command\UserCommand::class,

        Repository\RoleRepositoryInterface::class => Repository\RoleRepository::class,
        Repository\UserRepositoryInterface::class => Repository\UserRepository::class,
    ],
    'factories' => [
        Command\UserCommand::class => CommandFactory\UserCommandFactory::class,

        Options\RoleOptions::class => OptionsFactory\RoleOptionsFactory::class,

        Repository\RoleRepository::class => RepositoryFactory\RoleRepositoryFactory::class,
        Repository\UserRepository::class => RepositoryFactory\UserRepositoryFactory::class,
    ],
];
