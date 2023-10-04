<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Entity\Post;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Update;

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

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): void
    {
        $delete = new Delete('posts');
        $delete->where(['id = ?' => $id]);

        Executer::executeSql($delete, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function update(Post $post): void
    {
        $update = new Update('posts');
        $update->set(['content' => $post->getContent()]);
        $update->where(['id' => $post->getId()]);

        Executer::executeSql($update, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function insert(Post $post): void
    {
        $insert = new Insert('posts');
        $insert->values(['content' => $post->getContent()]);

        Executer::executeSql($insert, $this->adapter);
    }
}
