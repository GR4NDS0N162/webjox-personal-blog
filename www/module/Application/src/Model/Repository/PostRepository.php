<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Post;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class PostRepository implements PostRepositoryInterface
{
    public const MAIN_TABLE = 'posts';
    public const LINK_TABLE = 'posts_categories';

    public function __construct(
        private AdapterInterface $adapter,
        private Post $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = new Select(['p' => self::MAIN_TABLE]);
        $select->columns([
            'id'      => 'p.id',
            'content' => 'p.content',
        ], false);
        return Extracter::extractValues($select, $this->adapter, $this->prototype);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Post
    {
        $select = new Select(['p' => self::MAIN_TABLE]);
        $select->columns([
            'id'      => 'p.id',
            'content' => 'p.content',
        ], false);
        $select->where(['p.id = ?' => $id]);
        $object = Extracter::extractValue($select, $this->adapter, $this->prototype);
        assert(is_null($object) || $object instanceof Post);
        return $object;
    }
}
