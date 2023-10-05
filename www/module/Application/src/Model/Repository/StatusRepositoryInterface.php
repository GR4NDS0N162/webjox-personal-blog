<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\Status;

interface StatusRepositoryInterface
{
    /**
     * @return Status[]
     */
    public function findAll(): array;
}
