<?php

declare(strict_types=1);

namespace Application\Model\Options;

use Application\Model\Repository\StatusRepositoryInterface;

class StatusOptions
{
    public function __construct(
        private StatusRepositoryInterface $statusRepository,
    ) {}

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        $options = [];
        foreach ($this->statusRepository->findAll() as $status) {
            $options[$status->getId()] = $status->getName();
        }
        return $options;
    }
}
