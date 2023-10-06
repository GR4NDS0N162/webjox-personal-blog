<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Entity\Post;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\ImageRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Update;

class PostCommand implements PostCommandInterface
{
    public const POSTS = 'posts';
    public const POSTS_CATEGORIES = 'posts_categories';

    public function __construct(
        private AdapterInterface $adapter,
        private PostRepositoryInterface $postRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private ImageRepositoryInterface $imageRepository,
        private ImageCommandInterface $imageCommand,
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

        $insert = new Insert(self::POSTS_CATEGORIES);
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
        $delete = new Delete(self::POSTS_CATEGORIES);
        $delete->where([
            'post_id'     => $postId,
            'category_id' => $categoryId,
        ]);
        Executer::executeSql($delete, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): void
    {
        foreach ($this->imageRepository->findByPostId($id) as $image) {
            $this->imageCommand->removeById($image->getId());
        }

        $delete = new Delete(self::POSTS);
        $delete->where(['id' => $id]);
        Executer::executeSql($delete, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function update(Post $post): void
    {
        $update = new Update(self::POSTS);
        $update->where(['id' => $post->getId()]);
        $update->set([
            'content'   => $post->getContent(),
            'status_id' => $post->getStatusId(),
        ]);
        Executer::executeSql($update, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function insert(Post $post): int
    {
        $insert = new Insert(self::POSTS);
        $insert->values([
            'content'   => $post->getContent(),
            'status_id' => $post->getStatusId(),
        ]);
        return (int)Executer::executeSql($insert, $this->adapter);
    }

    /**
     * @inheritDoc
     */
    public function updateCategories(int $postId, array $categoryIds): void
    {
        $old = [];
        foreach ($this->categoryRepository->findByPostId($postId) as $category) {
            $old[] = $category->getId();
        }

        foreach ($old as $id) {
            if (!in_array($id, $categoryIds)) {
                $this->removePostFromCategory($postId, $id);
            }
        }

        foreach ($categoryIds as $id) {
            if (!in_array($id, $old)) {
                $this->addPostToCategory($postId, $id);
            }
        }
    }
}
