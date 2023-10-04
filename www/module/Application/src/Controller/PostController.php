<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Post\PostForm;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Form\FormElementManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    private PostForm $postForm;

    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
        private SessionContainer $sessionContainer,
        private PostRepositoryInterface $postRepository,
    ) {
        $this->postForm = $this->formElementManager->get(PostForm::class);
    }

    public function indexAction(): ViewModel|Response
    {
        $userId = $this->sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        if (!is_int($userId)) {
            return $this->redirect()->toRoute('home');
        }

        return new ViewModel();
    }

    public function getAction(): JsonModel
    {
        $userId = $this->sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        $data = ['list' => []];
        if (!is_int($userId)) {
            return new JsonModel($data);
        }

        $request = $this->getRequest();
        if (!$request->isGet()) {
            return new JsonModel($data);
        }

        $posts = $this->postRepository->findAll();
        foreach ($posts as $post) {
            $data['list'][] = $post->getHydrator()->extract($post);
        }

        return new JsonModel($data);
    }

    public function editAction(): ViewModel|Response
    {
        $userId = $this->sessionContainer->offsetGet(IndexController::USER_ID_KEY);
        if (!is_int($userId)) {
            return $this->redirect()->toRoute('home');
        }

        $postId = $this->params()->fromRoute('id');
        if (!is_null($postId)) {
            $post = $this->postRepository->findById((int)$postId);
            if (is_null($post)) {
                return $this->redirect()->toRoute('post');
            }
            $this->postForm->setData(['post' => $post->getHydrator()->extract($post)]);
        }

        $this->postForm->setAttribute('action', $this->url()->fromRoute('post/save'));

        return new ViewModel([
            'postId'   => $postId,
            'postForm' => $this->postForm,
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
            return $this->redirect()->toRoute('post');
        }

        $form = $this->postForm;

        $form->setData($request->getPost());
        if (!$form->isValid()) {
            return $this->redirect()->toRoute('post');
        }

        $data = $form->getData();

        return $this->redirect()->toRoute('post');
    }
}
