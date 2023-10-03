<?php

declare(strict_types=1);

namespace Application\Model\Command;

use Application\Model\Entity\Category;

interface CategoryCommandInterface
{
    /**
     * @param Category[] $old
     * @param Category[] $new
     *
     * @return void
     */
    public function applyChanges(array $old, array $new): void;
}
