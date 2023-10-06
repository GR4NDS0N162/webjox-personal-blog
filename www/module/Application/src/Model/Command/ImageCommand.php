<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Helper\Command\Executer;
use Application\Model\Repository\ImageRepositoryInterface;
use Application\Model\Repository\PostRepositoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use RuntimeException;

class ImageCommand implements ImageCommandInterface
{
    public const IMAGES = 'images';

    public function __construct(
        private AdapterInterface $adapter,
        private PostRepositoryInterface $postRepository,
        private ImageRepositoryInterface $imageRepository,
    ) {}

    public function insert(array $file, int $postId): mixed
    {
        if (empty($file['tmp_name'])) {
            return null;
        }

        do {
            $name = md5(microtime() . rand(0, 9999));
            $path = '/var/www/public/img/post/' . $name . '.png';
        }
        while (file_exists($path));
        if (!rename($file['tmp_name'], $path)) {
            throw new RuntimeException('Couldn\'t move the file');
        }

        $insert = new Insert(self::IMAGES);
        $insert->values([
            'path'    => $path,
            'post_id' => $postId,
        ]);
        return Executer::executeSql($insert, $this->adapter);
    }

    public function removeById(int $id): void
    {
        $image = $this->imageRepository->findById($id);
        unlink($image->getPath());

        $delete = new Delete(self::IMAGES);
        $delete->where(['id' => $id]);
        Executer::executeSql($delete, $this->adapter);
    }
}
