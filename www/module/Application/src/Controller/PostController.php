<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Post\PostForm;
use Application\Helper\Controller\Validator;
use Application\Model\Command\PostCommandInterface;
use Application\Model\Entity\Post;
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
        private PostCommandInterface $postCommand,
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
        $data = ['list' => []];

        if (!Validator::isValidSession($this->sessionContainer)) {
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

        $data['is_admin'] = $this->sessionContainer->offsetGet(IndexController::USER_ROLE_ID) == IndexController::ADMIN_ROLE_ID;

        return new JsonModel($data);
    }

    public function editAction(): ViewModel|Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
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
        else if (!Validator::isAdmin($this->sessionContainer)) {
            return $this->redirect()->toRoute('post');
        }

        $this->postForm->setAttribute('action', $this->url()->fromRoute('post/save'));

        return new ViewModel([
            'postId'   => $postId,
            'postForm' => $this->postForm,
        ]);
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
            $this->postCommand->insert($post);
        }
        else {
            $this->postCommand->update($post);
        }

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
