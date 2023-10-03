<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;

class PostCommand implements PostCommandInterface
{
    public function __construct(
        private AdapterInterface $adapter,
        private PostRepositoryInterface $postRepository,
        private CategoryRepositoryInterface $categoryRepository,
    ) {}

    /**
     * @inheritDoc
     */
    public function addPostToCategory(int $postId, int $categoryId): void
    {
        $post = $this->postRepository->findById($postId);
        if (is_null($post)) {
            return;
        }

        $category = $this->categoryRepository->findById($categoryId);
        if (is_null($category)) {
            return;
        }

        $categories = $this->categoryRepository->findByPostId($postId);
        foreach ($categories as $category) {
            if ($category->getId() == $categoryId) {
                return;
            }
        }

        $insert = new Insert('posts_categories');
        $insert->values([
            'post_id'     => $postId,
            'category_id' => $categoryId,
        ]);

        Executer::executeSql($insert, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function removePostFromCategory(int $postId, int $categoryId): void
    {
        $delete = new Delete('posts_categories');
        $delete->where([
            'post_id = ?'     => $postId,
            'category_id = ?' => $categoryId,
        ]);

        Executer::executeSql($delete, $this->adapter);
    }
}
