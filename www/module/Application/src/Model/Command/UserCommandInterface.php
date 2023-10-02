<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Model\Entity\User;

interface UserCommandInterface
{
    public function insertUser(User $user): ?int;
}
