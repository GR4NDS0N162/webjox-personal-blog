<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Image;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class ImageRepository implements ImageRepositoryInterface
{
    public const IMAGES = 'images';

    public function __construct(
        private AdapterInterface $adapter,
        private Image $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Image
    {
        $select = $this->getSelect();
        $select->where(['id' => $id]);
        $object = Extracter::extractValue($select, $this->adapter, $this->prototype);
        assert(is_null($object) || $object instanceof Image);
        return $object;
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = new Select(self::IMAGES);
        $select->columns([
            'id'      => 'id',
            'path'    => 'path',
            'post_id' => 'post_id',
        ]);
        return $select;
    }

    /**
     * @inheritDoc
     */
    public function findByPostId(int $postId): array
    {
        $select = $this->getSelect();
        $select->where(['post_id' => $postId]);
        return Extracter::extractValues($select, $this->adapter, $this->prototype);
    }
}
