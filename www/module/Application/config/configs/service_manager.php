<?php

declare(strict_types=1);

namespace Application;

use Application\Model\Command\CategoryCommand;
use Application\Model\Command\CategoryCommandInterface;
use Application\Model\Command\ImageCommand;
use Application\Model\Command\ImageCommandInterface;
use Application\Model\Command\PostCommand;
use Application\Model\Command\PostCommandInterface;
use Application\Model\Command\UserCommand;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Entity\Category;
use Application\Model\Entity\Role;
use Application\Model\Entity\User;
use Application\Model\Options\RoleOptions;
use Application\Model\Options\StatusOptions;
use Application\Model\Repository\CategoryRepository;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\ImageRepository;
use Application\Model\Repository\ImageRepositoryInterface;
use Application\Model\Repository\PostRepository;
use Application\Model\Repository\PostRepositoryInterface;
use Application\Model\Repository\RoleRepository;
use Application\Model\Repository\RoleRepositoryInterface;
use Application\Model\Repository\StatusRepository;
use Application\Model\Repository\StatusRepositoryInterface;
use Application\Model\Repository\UserRepository;
use Application\Model\Repository\UserRepositoryInterface;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'aliases'            => [
        UserCommandInterface::class        => UserCommand::class,
        PostCommandInterface::class        => PostCommand::class,
        CategoryCommandInterface::class    => CategoryCommand::class,
        RoleRepositoryInterface::class     => RoleRepository::class,
        UserRepositoryInterface::class     => UserRepository::class,
        PostRepositoryInterface::class     => PostRepository::class,
        ImageRepositoryInterface::class    => ImageRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        StatusRepositoryInterface::class   => StatusRepository::class,
        ImageCommandInterface::class       => ImageCommand::class,
    ],
    'factories'          => [
        Category::class           => InvokableFactory::class,
        User::class               => InvokableFactory::class,
        Role::class               => InvokableFactory::class,
        UserCommand::class        => ReflectionBasedAbstractFactory::class,
        CategoryCommand::class    => ReflectionBasedAbstractFactory::class,
        PostCommand::class        => ReflectionBasedAbstractFactory::class,
        RoleOptions::class        => ReflectionBasedAbstractFactory::class,
        RoleRepository::class     => ReflectionBasedAbstractFactory::class,
        UserRepository::class     => ReflectionBasedAbstractFactory::class,
        PostRepository::class     => ReflectionBasedAbstractFactory::class,
        ImageRepository::class    => ReflectionBasedAbstractFactory::class,
        CategoryRepository::class => ReflectionBasedAbstractFactory::class,
        StatusRepository::class   => ReflectionBasedAbstractFactory::class,
        StatusOptions::class      => ReflectionBasedAbstractFactory::class,
        ImageCommand::class       => ReflectionBasedAbstractFactory::class,
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
