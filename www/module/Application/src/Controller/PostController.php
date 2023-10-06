<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\Post\PostForm;
use Application\Helper\Controller\Validator;
use Application\Helper\Repository\SqlBuilder;
use Application\Model\Command\ImageCommandInterface;
use Application\Model\Command\PostCommandInterface;
use Application\Model\Entity\Post;
use Application\Model\Repository\CategoryRepositoryInterface;
use Application\Model\Repository\ImageRepositoryInterface;
use Application\Model\Repository\PostRepository;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Select;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\FormElementManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Paginator;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Session\Container as SessionContainer;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    public const DEFAULT_COUNT_PER_PAGE = 5;

    private PostForm $postForm;

    public function __construct(
        private ServiceManager $serviceManager,
        private FormElementManager $formElementManager,
        private SessionContainer $sessionContainer,
        private PostRepositoryInterface $postRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private PostCommandInterface $postCommand,
        private AdapterInterface $adapter,
        private ImageCommandInterface $imageCommand,
        private ImageRepositoryInterface $imageRepository,
        private Post $prototype,
    ) {
        $this->postForm = $this->formElementManager->get(PostForm::class);
    }

    public function indexAction(): ViewModel|Response
    {
        if (!Validator::isValidSession($this->sessionContainer)) {
            return $this->redirect()->toRoute('home');
        }

        $paginator = $this->getPaginator();

        return new ViewModel([
            'paginator' => $paginator,
            'count'     => $paginator->getItemCountPerPage(),
            'isAdmin'   => Validator::isAdmin($this->sessionContainer),
        ]);
    }

    private function getPaginator(): Paginator
    {
        $select = SqlBuilder::getPostSelect();

        $countSelect = new Select(PostRepository::POSTS);
        $countSelect->columns([DbSelect::ROW_COUNT_COLUMN_NAME => new Expression('COUNT(*)')]);

        $dbSelect = new DbSelect(
            $select,
            $this->adapter,
            new HydratingResultSet($this->prototype->getHydrator(), $this->prototype),
            $countSelect
        );

        $paginator = new Paginator($dbSelect);

        $count = (int)$this->params()->fromRoute('count');
        if ($count < 1) {
            $count = self::DEFAULT_COUNT_PER_PAGE;
        }
        $paginator->setItemCountPerPage($count);

        $page = $this->params()->fromRoute('page');
        $paginator->setCurrentPageNumber((int)$page);

        return $paginator;
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

            $imagesToRemoveElement = $this->postForm->get('images')->get('images_to_remove');
            assert($imagesToRemoveElement instanceof MultiCheckbox);
            $imagesToRemoveElement->setValueOptions($this->getImageToRemoveOptions($post->getId()));

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

        $this->postForm->setAttribute('action', $this->url()->fromRoute('post/save', is_null($postId) ? [] : ['id' => (int)$postId]));

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

    private function getImageToRemoveOptions(int $postId): array
    {
        $options = [];
        foreach ($this->imageRepository->findByPostId($postId) as $image) {
            $id = 'image_to_remove_option_' . $image->getId();
            $src = substr($image->getPath(), strlen('/var/www/public'));
            $options[] = [
                'value'            => $image->getId(),
                'label'            => sprintf('<img src="%s" alt="%s">', $src, $id),
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

        $postId = $this->params()->fromRoute('id');
        if (!is_null($postId)) {
            $imagesToRemoveElement = $this->postForm->get('images')->get('images_to_remove');
            assert($imagesToRemoveElement instanceof MultiCheckbox);
            $imagesToRemoveElement->setValueOptions($this->getImageToRemoveOptions((int)$postId));
        }

        $form->setData(array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray()));
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

        foreach ($data['images']['images_to_remove'] ?? [] as $imageId) {
            $this->imageCommand->removeById((int)$imageId);
        }

        foreach ($data['images']['images_to_add'] ?? [] as $imageFieldset) {
            $file = $imageFieldset['image'];
            $this->imageCommand->insert($file, $post->getId());
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
