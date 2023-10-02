<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Index\SignInForm;
use Application\Form\Index\SignUpForm;
use Application\Model\Command\UserCommandInterface;
use Application\Model\Entity\User;
use Application\Model\Repository\UserRepositoryInterface;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private SignInForm $signInForm;

    private SignUpForm $signUpForm;

    private UserRepositoryInterface $userRepository;

    private UserCommandInterface $userCommand;

    public function __construct(
        SignInForm $signInForm,
        SignUpForm $signUpForm,
        UserRepositoryInterface $userRepository,
        UserCommandInterface $userCommand,
    ) {
        $this->signInForm = $signInForm;
        $this->signUpForm = $signUpForm;
        $this->userRepository = $userRepository;
        $this->userCommand = $userCommand;
    }

    public function indexAction(): ViewModel
    {
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

        $this->signInForm->setData($request->getPost());

        if (!$this->signInForm->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $data = $this->signInForm->getData();

        // TODO: Authorize the user.

        return $this->redirect()->toRoute('home'); // Should be changed
    }

    public function signUpAction(): Response
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $this->signUpForm->setData($request->getPost());

        if (!$this->signUpForm->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $data = $this->signUpForm->getData();

        if ($data['new-password'] !== $data['password-check']) {
            return $this->redirect()->toRoute('home');
        }

        $user = $this->userRepository->findByEmail($data['email']);
        if (!is_null($user)) {
            return $this->redirect()->toRoute('home');
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($data['new-password']);
        $user->setRoleId((int)$data['role-id']);

        $user->setId($this->userCommand->insertUser($user));

        return $this->redirect()->toRoute('home');
    }
}
