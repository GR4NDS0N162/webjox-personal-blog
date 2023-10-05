<?php

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Role;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class RoleRepository implements RoleRepositoryInterface
{
    public const ROLES = 'roles';

    public function __construct(
        private AdapterInterface $db,
        private Role $prototype,
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
        $select = new Select(self::ROLES);
        $select->columns([
            'id'   => 'id',
            'name' => 'name',
        ]);
        return $select;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?Role
    {
        $select = $this->getSelect();
        $select->where([sprintf('%s.id', self::ROLES) => $id]);
        $object = Extracter::extractValue($select, $this->db, $this->prototype);
        assert(is_null($object) || $object instanceof Role);
        return $object;
    }
}
