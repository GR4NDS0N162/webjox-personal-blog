<?php

declare(strict_types=1);

namespace Application\Factory\Controller;

use Application\Controller\IndexController;
use Application\Form\Index\SignUpForm;
use Interop\Container\ContainerInterface;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var ContainerInterface $formManager */
        $formManager = $container->get(FormElementManager::class);

        /** @var SignUpForm $signUpForm */
        $signUpForm = $formManager->get(SignUpForm::class);

        return new IndexController(
            $signUpForm,
        );
    }
}
