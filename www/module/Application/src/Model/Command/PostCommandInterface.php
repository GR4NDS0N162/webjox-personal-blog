<?php

declare(strict_types=1);

namespace Application\Model\Command;

interface PostCommandInterface
{
    /**
     * @param int $postId
     * @param int $categoryId
     *
     * @return void
     */
    public function addPostToCategory(int $postId, int $categoryId): void;

    /**
     * @param int $postId
     * @param int $categoryId
     *
     * @return void
     */
    public function removePostFromCategory(int $postId, int $categoryId): void;

    /**
     * @param int $id
     *
     * @return void
     */
    public function deleteById(int $id): void;
}
