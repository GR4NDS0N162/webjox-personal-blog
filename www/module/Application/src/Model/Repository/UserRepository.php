<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\User;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class UserRepository implements UserRepositoryInterface
{
    public const USERS = 'users';

    public function __construct(
        private AdapterInterface $db,
        private User $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?User
    {
        $select = $this->getSelect();
        $select->where([sprintf('%s.id', self::USERS) => $id]);
        $object = Extracter::extractValue($select, $this->db, $this->prototype);
        assert(is_null($object) || $object instanceof User);
        return $object;
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = new Select(self::USERS);
        $select->columns([
            'id'       => 'id',
            'email'    => 'email',
            'password' => 'password',
            'role_id'  => 'role_id',
        ]);
        return $select;
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?User
    {
        $select = $this->getSelect();
        $select->where([sprintf('%s.email', self::USERS) => $email]);
        $object = Extracter::extractValue($select, $this->db, $this->prototype);
        assert(is_null($object) || $object instanceof User);
        return $object;
    }

    /**
     * @inheritDoc
     */
    public function findUsers(): array
    {
        $select = $this->getSelect();
        return Extracter::extractValues($select, $this->db, $this->prototype);
    }
}
