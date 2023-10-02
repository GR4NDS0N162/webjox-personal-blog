<?php

declare(strict_types=1);

namespace Application\Factory\Command;

use Application\Model\Command\UserCommand;
use Application\Model\Repository\UserRepositoryInterface;
use Interop\Container\Containerinterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserCommandFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var AdapterInterface $userRepository */
        $db = $container->get(AdapterInterface::class);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $container->get(UserRepositoryInterface::class);

        return new UserCommand(
            $db,
            $userRepository,
        );
    }
}
