<?php

declare(strict_types=1);

namespace Application;

return [
    'router'       => include __DIR__ . '/configs/router.php',
    'controllers'  => include __DIR__ . '/configs/controllers.php',
    'view_manager' => include __DIR__ . '/configs/view_manager.php',
];
