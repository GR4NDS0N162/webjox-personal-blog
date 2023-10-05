<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Model\Entity\Image;

interface ImageRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Image|null
     */
    public function findById(int $id): ?Image;

    /**
     * @param int $postId
     *
     * @return Image[]
     */
    public function findByPostId(int $postId): array;
}
