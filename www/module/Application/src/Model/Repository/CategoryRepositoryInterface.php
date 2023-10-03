<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return Category[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     *
     * @return Category|null
     */
    public function findById(int $id): ?Category;

    /**
     * @param int $postId
     *
     * @return Category[]
     */
    public function findByPostId(int $postId): array;
}
