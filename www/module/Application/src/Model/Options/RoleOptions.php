<?php

declare(strict_types=1);

namespace Application\Model\Options;

use Application\Model\Repository\RoleRepositoryInterface;

class RoleOptions
{
    /**
     * @var RoleRepositoryInterface
     */
    private RoleRepositoryInterface $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

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
