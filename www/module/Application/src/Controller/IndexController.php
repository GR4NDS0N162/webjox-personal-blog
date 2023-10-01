<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Index\SignInForm;
use Application\Form\Index\SignUpForm;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private SignInForm $signInForm;

    private SignUpForm $signUpForm;

    public function __construct(
        SignInForm $signInForm,
        SignUpForm $signUpForm,
    ) {
        $this->signInForm = $signInForm;
        $this->signUpForm = $signUpForm;
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

        // TODO: Register a user.

        return $this->redirect()->toRoute('home');
    }
}
