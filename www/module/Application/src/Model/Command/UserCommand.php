<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Entity\User;
use Application\Model\Repository\UserRepositoryInterface;
use InvalidArgumentException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Insert;

class UserCommand implements UserCommandInterface
{
    public const USERS = 'users';

    public function __construct(
        private AdapterInterface $db,
        private UserRepositoryInterface $userRepository,
    ) {}

    public function insertUser(User $user): int
    {
        $foundUser = $this->userRepository->findByEmail($user->getEmail());
        if (!is_null($foundUser)) {
            throw new InvalidArgumentException('User with email ' . $user->getEmail() . ' exists');
        }

        $insert = new Insert(self::USERS);
        $insert->values([
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'role_id'  => $user->getRoleId(),
        ]);

        return (int)Executer::executeSql($insert, $this->db);
    }
}
