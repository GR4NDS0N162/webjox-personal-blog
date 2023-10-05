<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Post\PostForm;
use Application\Helper\Controller\Validator;
use Application\Model\Command\PostCommandInterface;
use Application\Model\Entity\Post;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\FormElementManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
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

    public function indexAction(): ViewModel|Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
            return $this->redirect()->toRoute('home');
        }

        $posts = $this->postRepository->findAll();

        return new ViewModel([
            'posts'   => $posts,
            'isAdmin' => Validator::isAdmin($this->sessionContainer),
        ]);
    }

    public function editAction(): ViewModel|Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
            return $this->redirect()->toRoute('home');
        }

        $categoriesElement = $this->postForm->get('categories');
        assert($categoriesElement instanceof MultiCheckbox);
        $categoriesElement->setValueOptions($this->getOptions());

        $postId = $this->params()->fromRoute('id');
        if (!is_null($postId)) {
            $post = $this->postRepository->findById((int)$postId);
            if (is_null($post)) {
                return $this->redirect()->toRoute('post');
            }

            $selected = [];
            foreach ($this->categoryRepository->findByPostId($post->getId()) as $category) {
                $selected[] = $category->getId();
            }

            $categoriesElement->setValue($selected);

            $this->postForm->setData(['post' => $post->getHydrator()->extract($post)]);
        }
        else if (!Validator::isAdmin($this->sessionContainer)) {
            return $this->redirect()->toRoute('post');
        }

        $this->postForm->setAttribute('action', $this->url()->fromRoute('post/save'));

        return new ViewModel([
            'postId'   => $postId,
            'postForm' => $this->postForm,
        ]);
    }

    /**
     * @return array
     */
    private function getOptions(): array
    {
        $options = [];
        foreach ($this->categoryRepository->findAll() as $category) {
            $id = 'category_option_' . $category->getId();
            $options[] = [
                'value'            => $category->getId(),
                'label'            => $category->getName(),
                'attributes'       => [
                    'id' => $id,
                ],
                'label_attributes' => [
                    'for' => $id,
                ],
            ];
        }
        return $options;
    }

    public function saveAction(): Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
            return $this->redirect()->toRoute('home');
        }

        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('post');
        }

        $form = $this->postForm;
        $categoriesElement = $form->get('categories');
        assert($categoriesElement instanceof MultiCheckbox);
        $categoriesElement->setValueOptions($this->getOptions());

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('post');
        }

        $data = $form->getData();

        $post = $this->serviceManager->build(Post::class);
        assert($post instanceof Post);
        $post->getHydrator()->hydrate($data['post'], $post);

        if (is_null($post->getId())) {
            if (!Validator::isAdmin($this->sessionContainer)) {
                return $this->redirect()->toRoute('post');
            }
            $post->setId($this->postCommand->insert($post));
        }
        else {
            $this->postCommand->update($post);
        }

        $categoryIds = [];
        foreach ($data['categories'] ?: [] as $id) {
            $categoryIds[] = (int)$id;
        }
        $this->postCommand->updateCategories($post->getId(), $categoryIds);

        return $this->redirect()->toRoute('post');
    }

    public function deleteAction(): Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
            return $this->redirect()->toRoute('home');
        }

        if (!Validator::isAdmin($this->sessionContainer)) {
            return $this->redirect()->toRoute('post');
        }

        $postId = $this->params()->fromRoute('id');
        if (is_null($postId)) {
            return $this->redirect()->toRoute('post');
        }

        $this->postCommand->deleteById((int)$postId);

        return $this->redirect()->toRoute('post');
    }
}
