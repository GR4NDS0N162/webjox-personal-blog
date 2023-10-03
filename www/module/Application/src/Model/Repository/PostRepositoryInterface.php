<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\Post;

interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return Post|null
     */
    public function findById(int $id): ?Post;

}
