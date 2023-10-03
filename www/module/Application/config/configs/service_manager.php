<?php

declare(strict_types=1);

namespace Application;

use Application\Model\Command\UserCommand;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Entity\Role;
use Application\Model\Entity\User;
use Application\Model\Options\RoleOptions;
use Application\Model\Repository\RoleRepository;
use Application\Model\Repository\RoleRepositoryInterface;
use Application\Model\Repository\UserRepository;
use Application\Model\Repository\UserRepositoryInterface;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'aliases'            => [
        UserCommandInterface::class    => UserCommand::class,
        RoleRepositoryInterface::class => RoleRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
    ],
    'factories'          => [
        User::class           => InvokableFactory::class,
        Role::class           => InvokableFactory::class,
        UserCommand::class    => ReflectionBasedAbstractFactory::class,
        RoleOptions::class    => ReflectionBasedAbstractFactory::class,
        RoleRepository::class => ReflectionBasedAbstractFactory::class,
        UserRepository::class => ReflectionBasedAbstractFactory::class,
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
