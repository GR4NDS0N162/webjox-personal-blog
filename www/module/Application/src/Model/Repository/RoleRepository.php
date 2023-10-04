<?php

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Role;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class RoleRepository implements RoleRepositoryInterface
{
    public const MAIN_TABLE = 'roles';

    public function __construct(
        private AdapterInterface $db,
        private Role $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = new Select(['r' => self::MAIN_TABLE]);
        $select->columns([
            'id'   => 'r.id',
            'name' => 'r.name',
        ], false);
        return Extracter::extractValues($select, $this->db, $this->prototype);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Role
    {
        $select = new Select(['r' => self::MAIN_TABLE]);
        $select->columns([
            'id'   => 'r.id',
            'name' => 'r.name',
        ], false);
        $select->where(['r.id = ?' => $id]);
        $object = Extracter::extractValue($select, $this->db, $this->prototype);
        assert(is_null($object) || $object instanceof Role);
        return $object;
    }
}
