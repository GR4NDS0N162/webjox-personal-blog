<?php

declare(strict_types=1);

namespace Application\Helper\Command;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\Sql\Sql;

class Executer
{
    public static function executeSql(
        PreparableSqlInterface $preparableSql,
        AdapterInterface $adapter,
    ): mixed {
        $sql = new Sql($adapter);
        $statement = $sql->prepareStatementForSqlObject($preparableSql);
        $result = $statement->execute();

        return $result->getGeneratedValue();
    }
}
