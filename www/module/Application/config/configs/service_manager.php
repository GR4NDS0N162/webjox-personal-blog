<?php

declare(strict_types=1);

namespace Application;

use Application\Factory\Command\UserCommandFactory;
use Application\Factory\Options\RoleOptionsFactory;
use Application\Factory\Repository\RoleRepositoryFactory;
use Application\Factory\Repository\UserRepositoryFactory;
use Application\Model\Command\UserCommand;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Options\RoleOptions;
use Application\Model\Repository\RoleRepository;
use Application\Model\Repository\RoleRepositoryInterface;
use Application\Model\Repository\UserRepository;
use Application\Model\Repository\UserRepositoryInterface;

return [
    'aliases'            => [
        UserCommandInterface::class    => UserCommand::class,
        RoleRepositoryInterface::class => RoleRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
    ],
    'factories'          => [
        UserCommand::class    => UserCommandFactory::class,
        RoleOptions::class    => RoleOptionsFactory::class,
        RoleRepository::class => RoleRepositoryFactory::class,
        UserRepository::class => UserRepositoryFactory::class,
    ],
    'services'           => [
    ],
    'invokables'         => [
    ],
    'abstract_factories' => [
    ],
    'delegators'         => [
    ],
    'initializers'       => [
    ],
    'lazy_services'      => [
    ],
    'shared'             => [
    ],
    'shared_by_default'  => true,
];
