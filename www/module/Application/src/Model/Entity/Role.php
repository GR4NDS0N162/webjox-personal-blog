<?php

declare(strict_types=1);

namespace Application\Model\Entity;

use Laminas\Filter\ToInt;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\NullableStrategy;
use Laminas\Hydrator\Strategy\ScalarTypeStrategy;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\StringLength;

class Role implements InputFilterAwareInterface, HydratorAwareInterface
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var InputFilterInterface
     */
    private InputFilterInterface $inputFilter;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    /**
     * @param int|null $id
     * @param string   $name
     */
    public function __construct(?int $id = null, string $name = '')
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Role
     */
    public function setId(?int $id): Role
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;
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

        $this->inputFilter->add([
            'name'       => 'id',
            'filters'    => [
                [
                    'name' => ToInt::class,
                ],
            ],
            'validators' => [
                [
                    'name'    => GreaterThan::class,
                    'options' => [
                        'min' => 0,
                    ],
                ],
            ],
        ]);

        $this->inputFilter->add([
            'name'       => 'name',
            'required'   => true,
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'max'      => 255,
                    ],
                ],
            ],
        ]);

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

        $this->hydrator->addStrategy(
            'id',
            new NullableStrategy(ScalarTypeStrategy::createToInt(), true)
        );

        $this->hydrator->addStrategy(
            'name',
            ScalarTypeStrategy::createToString()
        );

        return $this->hydrator;
    }
}
