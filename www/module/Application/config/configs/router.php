<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\IndexController;
use Laminas\Router\Http\Literal;

return [
    'routes' => [
        'home' => [
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
    ],
];
