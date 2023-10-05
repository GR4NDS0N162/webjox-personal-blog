<?php

declare(strict_types=1);

namespace Application\Model\Repository;

use Application\Helper\Repository\Extracter;
use Application\Model\Entity\Status;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\Select;

class StatusRepository implements StatusRepositoryInterface
{
    public const STATUSES = 'statuses';

    public function __construct(
        private AdapterInterface $db,
        private Status $prototype,
    ) {}

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $select = $this->getSelect();
        return Extracter::extractValues($select, $this->db, $this->prototype);
    }

    /**
     * @return Select
     */
    private function getSelect(): Select
    {
        $select = new Select(self::STATUSES);
        $select->columns([
            'id'   => 'id',
            'name' => 'name',
        ]);
        return $select;
    }
}
