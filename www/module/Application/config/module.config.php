<?php

declare(strict_types=1);

namespace Application;

use Laminas\Session\Container;
use Laminas\Session\Storage\SessionArrayStorage;

return [
    'service_manager'    => include __DIR__ . '/configs/service_manager.php',
    'router'             => include __DIR__ . '/configs/router.php',
    'form_elements'      => include __DIR__ . '/configs/form_elements.php',
    'controllers'        => include __DIR__ . '/configs/controllers.php',
    'view_helpers'       => include __DIR__ . '/configs/view_helpers.php',
    'view_manager'       => include __DIR__ . '/configs/view_manager.php',
    'session_containers' => [
        Container::class,
    ],
    'session_storage'    => [
        'type' => SessionArrayStorage::class,
    ],
    'session_config'     => [
        'gc_maxlifetime' => 7200,
    ],
];
