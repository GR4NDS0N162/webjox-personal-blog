<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Category;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private AdapterInterface $db,
        private Category $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = new Select(['c' => 'categories']);
        $select->columns([
            'id'   => 'c.id',
            'name' => 'c.name',
        ], false);

        return Extracter::extractValues(
            $select,
            $this->db,
            $this->prototype->getHydrator(),
            $this->prototype
        );
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Category
    {
        $select = new Select(['c' => 'categories']);
        $select->columns([
            'id'   => 'c.id',
            'name' => 'c.name',
        ], false);
        $select->where(['c.id = ?' => $id]);

        $object = Extracter::extractValue(
            $select,
            $this->db,
            $this->prototype->getHydrator(),
            $this->prototype
        );
        assert($object instanceof Category);

        return $object;
    }
}
