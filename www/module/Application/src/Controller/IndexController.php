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
        // TODO: Process the request.

        // TODO: Enter the user data into the database.

        return $this->redirect()->toRoute('home');
    }
}
