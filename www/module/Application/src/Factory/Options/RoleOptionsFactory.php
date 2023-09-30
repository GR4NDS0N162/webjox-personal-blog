<?php

declare(strict_types=1);

namespace Application\Factory\Options;

use Application\Model\Options\RoleOptions;
use Application\Model\Repository\RoleRepositoryInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RoleOptionsFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var RoleRepositoryInterface $roleRepository */
        $roleRepository = $container->get(RoleRepositoryInterface::class);

        return new RoleOptions(
            $roleRepository,
        );
    }
}
