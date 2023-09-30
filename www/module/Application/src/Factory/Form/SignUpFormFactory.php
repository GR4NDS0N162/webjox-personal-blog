<?php

declare(strict_types=1);

namespace Application\Factory\Form;

use Application\Form\Index\SignUpForm;
use Application\Model\Options\RoleOptions;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SignUpFormFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var RoleOptions $roleOptions */
        $roleOptions = $container->get(RoleOptions::class);

        return new SignUpForm(
            $roleOptions
        );
    }
}
