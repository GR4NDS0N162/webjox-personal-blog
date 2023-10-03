<?php

declare(strict_types=1);

namespace Application\Controller;

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
    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
        private SessionContainer $sessionContainer,
        private PostRepositoryInterface $postRepository,
    ) {}

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
        if (!is_int($userId)) {
            return new JsonModel();
        }

        $request = $this->getRequest();
        if (!$request->isGet()) {
            return new JsonModel();
        }

        $posts = $this->postRepository->findAll();
        $data = ['list' => []];
        foreach ($posts as $post) {
            $data['list'][] = $post->getHydrator()->extract($post);
        }

        return new JsonModel($data);
    }
}
