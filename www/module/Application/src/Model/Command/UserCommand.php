<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Model\Entity\User;
use Application\Model\Repository\UserRepositoryInterface;

class UserCommand implements UserCommandInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function insertUser(User $user): int
    {
        // TODO: Implement insertUser() method.
    }
}
