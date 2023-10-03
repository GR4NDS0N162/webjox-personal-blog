<?php

declare(strict_types=1);

namespace Application\Model\Entity;

class User
{
    public function __construct(
        private ?int $id = null,
        private ?string $email = null,
        private ?string $password = null,
        private ?int $roleId = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(?int $roleId): User
    {
        $this->roleId = $roleId;
        return $this;
    }
}
