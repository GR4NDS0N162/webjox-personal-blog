<?php

namespace Application\Model\Repository;

use Application\Model\Entity\Role;

interface RoleRepositoryInterface
{
    /**
     * @return Role[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return Role
     */
    public function findById(int $id): Role;
}
