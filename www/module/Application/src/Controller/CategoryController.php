<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Form\FormElementManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;

class CategoryController extends AbstractActionController
{
    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
    ) {}
}
