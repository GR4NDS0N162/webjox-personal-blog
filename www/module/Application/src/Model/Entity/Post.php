<?php

declare(strict_types=1);

namespace Application\Model\Entity;

use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\NullableStrategy;
use Laminas\Hydrator\Strategy\ScalarTypeStrategy;

class Post implements HydratorAwareInterface
{
    private HydratorInterface $hydrator;

    public function __construct(
        private ?int $id = null,
        private ?string $content = null,
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Post
    {
        $this->content = $content;
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
        $this->hydrator->addStrategy('content', new NullableStrategy(ScalarTypeStrategy::createToString(), true));

        return $this->hydrator;
    }
}
