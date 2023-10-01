<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Index\SignUpForm;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private SignUpForm $signUpForm;

    public function __construct(SignUpForm $signUpForm)
    {
        $this->signUpForm = $signUpForm;
    }

    public function indexAction(): ViewModel
    {
        return new ViewModel([
            'signUpForm' => $this->signUpForm,
        ]);
    }

    public function signUpAction(): Response
    {
        $request = $this->getRequest();

        // TODO: Handle the request.

        return $this->redirect()->toRoute('home');
    }
}
