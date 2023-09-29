<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction(): ViewModel
    {
        return new ViewModel();
    }
}
