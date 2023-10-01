<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\User;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class UserRepository implements UserRepositoryInterface
{
    private AdapterInterface $db;

    private User $prototype;

    public function __construct(AdapterInterface $db)
    {
        $this->db = $db;
        $this->prototype = new User();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): User
    {
        $select = new Select(['u' => 'users']);
        $select->columns([
            'id'       => 'u.id',
            'email'    => 'u.email',
            'password' => 'u.password',
            'role_id'  => 'u.role_id',
        ], false);
        $select->where(['u.id = ?' => $id]);

        /** @var User $object */
        $object = Extracter::extractValue(
            $select,
            $this->db,
            $this->prototype->getHydrator(),
            $this->prototype
        );

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function findUsers(): array
    {
        $select = new Select(['u' => 'users']);
        $select->columns([
            'id'       => 'u.id',
            'email'    => 'u.email',
            'password' => 'u.password',
            'role_id'  => 'u.role_id',
        ], false);

        return Extracter::extractValues(
            $select,
            $this->db,
            $this->prototype->getHydrator(),
            $this->prototype
        );
    }
}
