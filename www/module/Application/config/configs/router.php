<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\CategoryController;
use Application\Controller\IndexController;
use Application\Controller\PostController;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'routes' => [
        'home'     => [
            'type'          => Literal::class,
            'options'       => [
                'route'    => '/',
                'defaults' => [
                    'controller' => IndexController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'signin' => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => 'signin',
                        'defaults' => [
                            'action' => 'signin',
                        ],
                    ],
                ],
                'signup' => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => 'signup',
                        'defaults' => [
                            'action' => 'signup',
                        ],
                    ],
                ],
            ],
        ],
        'category' => [
            'type'          => Literal::class,
            'options'       => [
                'route'    => '/category',
                'defaults' => [
                    'controller' => CategoryController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'save' => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => '/save',
                        'defaults' => [
                            'action' => 'save',
                        ],
                    ],
                ],
            ],
        ],
        'post'     => [
            'type'          => Literal::class,
            'options'       => [
                'route'    => '/post',
                'defaults' => [
                    'controller' => PostController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'get'  => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => '/get',
                        'defaults' => [
                            'action' => 'get',
                        ],
                    ],
                ],
                'edit' => [
                    'type'    => Segment::class,
                    'options' => [
                        'route'       => '/edit/[:id]',
                        'constraints' => [
                            'id' => '[0-9]*',
                        ],
                        'defaults'    => [
                            'action' => 'edit',
                        ],
                    ],
                ],
                'save' => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => '/save',
                        'defaults' => [
                            'action' => 'save',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
