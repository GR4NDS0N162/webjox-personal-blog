<?php

declare(strict_types=1);

namespace Application\Helper\Repository;

use Application\Model\Repository\PostRepository;
use Laminas\Db\Sql\Select;

class SqlBuilder
{
    public static function getPostSelect(): Select
    {
        $select = new Select(PostRepository::POSTS);
        $select->columns([
            'id'      => 'id',
            'content' => 'content',
        ]);
        $select->join(
            PostRepository::STATUSES,
            sprintf('%s.status_id = %s.id', PostRepository::POSTS, PostRepository::STATUSES),
            [
                'status_id'   => 'id',
                'status_name' => 'name',
            ],
        );
        return $select;
    }
}
