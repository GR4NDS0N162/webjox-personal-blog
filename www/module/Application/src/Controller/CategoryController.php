<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Category\CategoryForm;
use Application\Model\Repository\CategoryRepositoryInterface;
use Laminas\Form\FormElementManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{
    private CategoryForm $categoryForm;

    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
        private SessionContainer $sessionContainer,
        private CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->categoryForm = $this->formElementManager->get(CategoryForm::class);
    }

    public function indexAction(): ViewModel|Response
    {
        $userId = $this->sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        if (!is_int($userId)) {
            return $this->redirect()->toRoute('home');
        }

        $categories = $this->categoryRepository->findAll();
        $data = ['list' => []];
        foreach ($categories as $category) {
            $data['list'][] = $category->getHydrator()->extract($category);
        }

        $this->categoryForm->setData($data);
        $this->categoryForm->setAttribute('action', $this->url()->fromRoute('category/save'));

        return new ViewModel([
            'categoryForm' => $this->categoryForm,
        ]);
    }

    public function saveAction(): Response
    {
        $userId = $this->sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        if (!is_int($userId)) {
            return $this->redirect()->toRoute('home');
        }

        return $this->redirect()->toRoute('category');
    }
}
