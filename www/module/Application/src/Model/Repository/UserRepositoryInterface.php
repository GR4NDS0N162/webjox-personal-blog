<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @return User[]
     */
    public function findUsers(): array;
}
