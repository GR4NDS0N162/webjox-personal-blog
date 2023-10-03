<?php

declare(strict_types=1);

namespace Application\Model\Entity;

class Role
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Role
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Role
    {
        $this->name = $name;
        return $this;
    }
}
