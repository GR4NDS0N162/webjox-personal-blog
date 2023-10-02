<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Entity\User;
use Application\Model\Repository\UserRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Insert;

class UserCommand implements UserCommandInterface
{
    private AdapterInterface $db;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        AdapterInterface $db,
        UserRepositoryInterface $userRepository,
    ) {
        $this->db = $db;
        $this->userRepository = $userRepository;
    }

    public function insertUser(User $user): ?int
    {
        $foundUser = $this->userRepository->findByEmail($user->getEmail());
        if ($foundUser) {
            return null;
        }

        $insert = new Insert('users');
        $insert->values([
            'email'    => $user->getEmail(),
            'password' => $user->getPassword(),
            'role_id'  => $user->getRoleId(),
        ]);

        $user->setId((int)Executer::executeSql($insert, $this->db));

        return $user->getId();
    }
}
