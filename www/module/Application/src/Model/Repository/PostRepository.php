<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Helper\Repository\SqlBuilder;
use Application\Model\Entity\Post;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class PostRepository implements PostRepositoryInterface
{
    public const POSTS = 'posts';
    public const POSTS_CATEGORIES = 'posts_categories';
    public const STATUSES = 'statuses';

    public function __construct(
        private AdapterInterface $adapter,
        private Post $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = $this->getSelect();
        return Extracter::extractValues($select, $this->adapter, $this->prototype);
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        return SqlBuilder::getPostSelect();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Post
    {
        $select = $this->getSelect();
        $select->where([sprintf('%s.id', self::POSTS) => $id]);
        $object = Extracter::extractValue($select, $this->adapter, $this->prototype);
        assert(is_null($object) || $object instanceof Post);
        return $object;
    }
}
