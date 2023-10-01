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
    private InputFilterInterface $inputFilter;

    private HydratorInterface $hydrator;

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
