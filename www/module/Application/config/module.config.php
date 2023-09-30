<?php

declare(strict_types=1);

namespace Application;

return [
    'service_manager' => include __DIR__ . '/configs/service_manager.php',
    'router'          => include __DIR__ . '/configs/router.php',
    'form_elements'   => include __DIR__ . '/configs/form_elements.php',
    'controllers'     => include __DIR__ . '/configs/controllers.php',
    'view_helpers'    => include __DIR__ . '/configs/view_helpers.php',
    'view_manager'    => include __DIR__ . '/configs/view_manager.php',
];
