<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;

return [
    'routes' => [
        'home' => [
            'type'          => Literal::class,
            'options'       => [
                'route'    => '/',
                'defaults' => [
                    'controller' => Controller\IndexController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'signup' => [
                    'type'    => 'literal',
                    'options' => [
                        'route'    => '/signup',
                        'defaults' => [
                            'action' => 'signup',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
