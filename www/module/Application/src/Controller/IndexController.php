<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Index\SignInForm;
use Application\Form\Index\SignUpForm;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Entity\User;
use Application\Model\Repository\UserRepositoryInterface;
use Laminas\Form\FormElementManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class IndexController extends AbstractActionController
{
    const USER_ID_KEY = 'user_id';

    private SignInForm $signInForm;

    private SignUpForm $signUpForm;

    public function __construct(
        private FormElementManager $formElementManager,
        private ServiceManager $serviceManager,
        private UserRepositoryInterface $userRepository,
        private UserCommandInterface $userCommand,
        private SessionContainer $sessionContainer,
    ) {
        $this->signInForm = $this->formElementManager->get(SignInForm::class);
        $this->signUpForm = $this->formElementManager->get(SignUpForm::class);
    }

    public function indexAction(): ViewModel
    {
        $this->signInForm->setAttribute('action', $this->url()->fromRoute('home/signin'));
        $this->signUpForm->setAttribute('action', $this->url()->fromRoute('home/signup'));

        return new ViewModel([
            'signInForm' => $this->signInForm,
            'signUpForm' => $this->signUpForm,
        ]);
    }

    public function signInAction(): Response
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $form = $this->signInForm;

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $data = $form->getData();

        $user = $this->serviceManager->get(User::class);
        assert($user instanceof User);
        $user->getHydrator()->hydrate($data['user'], $user);

        $foundUser = $this->userRepository->findByEmail($user->getEmail());
        if (is_null($foundUser)) {
            return $this->redirect()->toRoute('home');
        }

        if (strcmp($user->getPassword(), $foundUser->getPassword()) != 0) {
            return $this->redirect()->toRoute('home');
        }

        $this->sessionContainer->offsetSet(self::USER_ID_KEY, $foundUser->getId());
        return $this->redirect()->toRoute('category');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function signUpAction(): Response
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $form = $this->signUpForm;

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $data = $form->getData();

        $user = $this->serviceManager->get(User::class);
        assert($user instanceof User);
        $user->getHydrator()->hydrate($data['user'], $user);

        if (strcmp($user->getPassword(), $data['password_check']) != 0) {
            return $this->redirect()->toRoute('home');
        }

        $foundUser = $this->userRepository->findByEmail($user->getEmail());
        if (!is_null($foundUser)) {
            return $this->redirect()->toRoute('home');
        }

        $user->setId($this->userCommand->insertUser($user));
        $this->sessionContainer->offsetSet(self::USER_ID_KEY, $user->getId());
        return $this->redirect()->toRoute('category');
    }
}
