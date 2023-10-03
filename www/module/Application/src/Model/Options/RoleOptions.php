<?php

declare(strict_types=1);

namespace Application\Model\Options;

use Application\Model\Repository\RoleRepositoryInterface;

class RoleOptions
{
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
    ) {}

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        $roles = $this->roleRepository->findAll();

        $options = [];
        foreach ($roles as $role) {
            $options[$role->getId()] = $role->getName();
        }

        return $options;
    }
}
