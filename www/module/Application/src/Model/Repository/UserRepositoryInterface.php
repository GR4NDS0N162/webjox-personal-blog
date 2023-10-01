<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return User
     */
    public function findById(int $id): User;

    /**
     * @return User[]
     */
    public function findUsers(): array;
}
