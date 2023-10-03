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
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function __construct(
        private FormElementManager $formElementManager,
        private UserRepositoryInterface $userRepository,
        private UserCommandInterface $userCommand,
    ) {}

    public function indexAction(): ViewModel
    {
        $signInForm = $this->getSignInForm();
        $signUpForm = $this->getSignUpForm();

        $signInForm->setAttribute('action', $this->url()->fromRoute('home/signin'));
        $signUpForm->setAttribute('action', $this->url()->fromRoute('home/signup'));

        return new ViewModel([
            'signInForm' => $signInForm,
            'signUpForm' => $signUpForm,
        ]);
    }

    private function getSignInForm(): SignInForm
    {
        $signInForm = $this->formElementManager->get(SignInForm::class);
        assert($signInForm instanceof SignInForm);
        return $signInForm;
    }

    private function getSignUpForm(): SignUpForm
    {
        $signUpForm = $this->formElementManager->get(SignUpForm::class);
        assert($signUpForm instanceof SignUpForm);
        return $signUpForm;
    }

    public function signInAction(): Response
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $form = $this->getSignInForm();
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $data = $form->getData();

        // TODO: Authorize the user.

        return $this->redirect()->toRoute('home'); // Should be changed
    }

    public function signUpAction(): Response
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('home');
        }

        $form = $this->getSignUpForm();
        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('home');
        }

        $user = $form->get('user')->getObject();
        assert($user instanceof User);

        $passwordCheck = $form->get('password_check')->getValue();

        if (strcmp($user->getPassword(), $passwordCheck) != 0) {
            return $this->redirect()->toRoute('home');
        }

        $foundUser = $this->userRepository->findByEmail($user->getEmail());
        if (!is_null($foundUser)) {
            return $this->redirect()->toRoute('home');
        }

        $user->setId($this->userCommand->insertUser($user));

        return $this->redirect()->toRoute('home');
    }
}
