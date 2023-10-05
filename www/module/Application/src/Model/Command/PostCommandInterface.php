<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Model\Entity\Post;

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
     * @param int   $postId
     * @param int[] $categoryIds
     *
     * @return void
     */
    public function updateCategories(int $postId, array $categoryIds): void;

    /**
     * @param int $id
     *
     * @return void
     */
    public function deleteById(int $id): void;

    /**
     * @param Post $post
     *
     * @return void
     */
    public function update(Post $post): void;

    /**
     * @param Post $post
     *
     * @return mixed|null
     */
    public function insert(Post $post): mixed;
}
