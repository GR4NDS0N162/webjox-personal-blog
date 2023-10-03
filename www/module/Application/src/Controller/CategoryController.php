<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Category\CategoryForm;
use Application\Model\Command\CategoryCommandInterface;
use Application\Model\Entity\Category;
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
        private CategoryCommandInterface $categoryCommand,
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

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('category');
        }

        $form = $this->categoryForm;

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('category');
        }

        $data = $form->getData();

        $oldCategories = $this->categoryRepository->findAll();
        $newCategories = [];
        foreach ($data['list'] as $categoryData) {
            $category = $this->serviceManager->build(Category::class);
            assert($category instanceof Category);
            $category->getHydrator()->hydrate($categoryData, $category);
            $newCategories[] = $category;
        }

        $this->categoryCommand->applyChanges($oldCategories, $newCategories);

        return $this->redirect()->toRoute('category');
    }
}
