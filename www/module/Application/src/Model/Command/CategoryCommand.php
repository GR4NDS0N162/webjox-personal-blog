<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Entity\Category;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\Update;

class CategoryCommand implements CategoryCommandInterface
{
    public function __construct(
        private AdapterInterface $adapter,
    ) {}

    /**
     * @inheritDoc
     */
    public function applyChanges(array $old, array $new): void
    {
        $oldIds = [];
        foreach ($old as $category) {
            $oldIds[] = $category->getId();
        }

        $newIds = [];
        foreach ($new as $category) {
            $oldIds[] = $category->getId();
        }

        foreach ($old as $category) {
            if (!in_array($category->getId(), $newIds)) {
                $this->deleteById($category->getId());
            }
        }

        foreach ($new as $category) {
            if (in_array($category->getId(), $oldIds)) {
                $this->update($category);
            }
            else {
                $this->add($category);
            }
        }
    }

    public function deleteById(int $id): void
    {
        $delete = new Delete('categories');
        $delete->where(['id = ?' => $id]);

        Executer::executeSql($delete, $this->adapter);
    }

    public function update(Category $category): void
    {
        $update = new Update('categories');
        $update->set(['name' => $category->getName()]);
        $update->where(['id' => $category->getId()]);

        Executer::executeSql($update, $this->adapter);
    }

    public function add(Category $category): void
    {
        $insert = new Insert('categories');
        $insert->values(['name' => $category->getName()]);

        Executer::executeSql($insert, $this->adapter);
    }
}
