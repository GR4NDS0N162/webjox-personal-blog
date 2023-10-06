<?php

declare(strict_types=1);

namespace Application\Model\Command;

interface ImageCommandInterface
{
    public function insert(array $file, int $postId): mixed;

    public function removeById(int $id): void;
}
