<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Category;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class CategoryRepository implements CategoryRepositoryInterface
{
    public const CATEGORIES = 'categories';
    public const POSTS_CATEGORIES = 'posts_categories';

    public function __construct(
        private AdapterInterface $db,
        private Category $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = $this->getSelect();
        return Extracter::extractValues($select, $this->db, $this->prototype);
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = new Select(self::CATEGORIES);
        $select->columns([
            'id'   => 'id',
            'name' => 'name',
        ]);
        return $select;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Category
    {
        $select = $this->getSelect();
        $select->where([sprintf('%s.id', self::CATEGORIES) => $id]);
        $object = Extracter::extractValue($select, $this->db, $this->prototype);
        assert(is_null($object) || $object instanceof Category);
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function findByPostId(int $postId): array
    {
        $select = $this->getSelect();
        $select->join(
            self::POSTS_CATEGORIES,
            sprintf('%s.category_id = %s.id', self::POSTS_CATEGORIES, self::CATEGORIES),
            [],
        );
        $select->where([sprintf('%s.post_id', self::POSTS_CATEGORIES) => $postId]);
        return Extracter::extractValues($select, $this->db, $this->prototype);
    }
}
