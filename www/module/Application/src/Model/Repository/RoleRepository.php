<?php

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Role;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class RoleRepository implements RoleRepositoryInterface
{
    private AdapterInterface $db;

    private Role $prototype;

    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
        $this->prototype = new Role();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = new Select(['r' => 'roles']);
        $select->columns([
            'id'   => 'r.id',
            'name' => 'r.name',
        ], false);
        $select->order(['r.name ASC']);

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
    public function findById(int $id): Role
    {
        $select = new Select(['r' => 'roles']);
        $select->columns([
            'id'   => 'r.id',
            'name' => 'r.name',
        ], false);
        $select->where(['r.id = ?' => $id]);

        /** @var Role $object */
        $object = Extracter::extractValue(
            $select,
            $this->db,
            $this->prototype->getHydrator(),
            $this->prototype
        );

        return $object;
    }
}
