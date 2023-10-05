<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Post\PostForm;
use Application\Model\Command\PostCommandInterface;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Form\FormElementManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;

class PostManagementController extends AbstractActionController
{
    private PostForm $postForm;

    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
        private SessionContainer $sessionContainer,
        private PostRepositoryInterface $postRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private PostCommandInterface $postCommand,
    ) {
        $this->postForm = $this->formElementManager->get(PostForm::class);
    }
}
