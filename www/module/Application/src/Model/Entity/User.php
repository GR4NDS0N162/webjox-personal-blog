<?php

declare(strict_types=1);

namespace Application\Model\Entity;

use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\NullableStrategy;
use Laminas\Hydrator\Strategy\ScalarTypeStrategy;

class User implements HydratorAwareInterface
{
    private HydratorInterface $hydrator;

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

    /**
     * @inheritDoc
     */
    public function setHydrator(HydratorInterface $hydrator): void
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function getHydrator(): ?HydratorInterface
    {
        if (isset($this->hydrator)) {
            return $this->hydrator;
        }

        $this->hydrator = new ClassMethodsHydrator(true, true);

        $this->hydrator->addStrategy('id', new NullableStrategy(ScalarTypeStrategy::createToInt(), true));
        $this->hydrator->addStrategy('email', new NullableStrategy(ScalarTypeStrategy::createToString(), true));
        $this->hydrator->addStrategy('password', new NullableStrategy(ScalarTypeStrategy::createToString(), true));
        $this->hydrator->addStrategy('role_id', new NullableStrategy(ScalarTypeStrategy::createToInt(), true));

        return $this->hydrator;
    }
}
