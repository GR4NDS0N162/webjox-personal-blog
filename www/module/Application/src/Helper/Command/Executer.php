<?php

declare(strict_types=1);

namespace Application\Helper\Command;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\Sql\Sql;

class Executer
{
    public static function executeSql(
        PreparableSqlInterface $preparable,
        AdapterInterface $db,
    ): mixed {
        $sql = new Sql($db);
        $statement = $sql->prepareStatementForSqlObject($preparable);
        $result = $statement->execute();

        return $result->getGeneratedValue();
    }
}
