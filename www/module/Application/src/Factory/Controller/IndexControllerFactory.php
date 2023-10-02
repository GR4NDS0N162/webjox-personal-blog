<?php

declare(strict_types=1);

namespace Application\Factory\Controller;

use Application\Controller\IndexController;
use Application\Form\Index\SignInForm;
use Application\Form\Index\SignUpForm;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Repository\UserRepositoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        /** @var ContainerInterface $formManager */
        $formManager = $container->get(FormElementManager::class);

        /** @var SignInForm $signUpForm */
        $signInForm = $formManager->get(SignInForm::class);

        /** @var SignUpForm $signUpForm */
        $signUpForm = $formManager->get(SignUpForm::class);

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $container->get(UserRepositoryInterface::class);

        /** @var UserCommandInterface $userCommand */
        $userCommand = $container->get(UserCommandInterface::class);

        return new IndexController(
            $signInForm,
            $signUpForm,
            $userRepository,
            $userCommand,
        );
    }
}
