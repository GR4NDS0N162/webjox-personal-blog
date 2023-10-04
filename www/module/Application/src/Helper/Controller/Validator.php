<?php

declare(strict_types=1);

namespace Application\Helper\Controller;

use Application\Controller\IndexController;
use Laminas\Session\Container as SessionContainer;

class Validator
{
    public static function isValidSession(SessionContainer $sessionContainer): bool
    {
        $userId = $sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        $userRoleId = $sessionContainer->offsetGet(IndexController::USER_ROLE_ID);
        return is_int($userId) && is_int($userRoleId);
    }

    public static function isAdmin(SessionContainer $sessionContainer): bool
    {
        $userRoleId = $sessionContainer->offsetGet(IndexController::USER_ROLE_ID);
        return $userRoleId == IndexController::ADMIN_ROLE_ID;
    }
}
