<?php

declare(strict_types=1);

namespace Application\Factory\Controller;

use Application\Controller\LoginController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoginControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): LoginController
    {
        return new LoginController();
    }
}
