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
    public const POSTS_IMAGES = 'posts_images';

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
        $select->where([sprintf('%s.id', self::IMAGES) => $id]);
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
            'id'   => 'id',
            'path' => 'path',
        ]);
        return $select;
    }

    /**
     * @inheritDoc
     */
    public function findByPostId(int $postId): array
    {
        $select = $this->getSelect();
        $select->join(
            self::POSTS_IMAGES,
            sprintf('%s.image_id = %s.id', self::POSTS_IMAGES, self::IMAGES),
            [],
        );
        $select->where([sprintf('%s.post_id', self::POSTS_IMAGES) => $postId]);
        return Extracter::extractValues($select, $this->adapter, $this->prototype);
    }
}
