<?php

declare(strict_types=1);

namespace Application\Model\Entity;

use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface, HydratorAwareInterface
{
    private ?int $id;

    private ?string $email;

    private ?string $password;

    private ?int $roleId;

    private InputFilterInterface $inputFilter;

    private HydratorInterface $hydrator;

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
    public function setInputFilter(InputFilterInterface $inputFilter): void
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @inheritDoc
     */
    public function getInputFilter(): InputFilterInterface
    {
        if (!empty($this->inputFilter)) {
            return $this->inputFilter;
        }

        $this->inputFilter = new InputFilter();

        return $this->inputFilter;
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
        if (!empty($this->hydrator)) {
            return $this->hydrator;
        }

        $this->hydrator = new ClassMethodsHydrator(false);

        return $this->hydrator;
    }
}
