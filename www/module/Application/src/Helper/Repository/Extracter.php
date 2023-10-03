<?php

namespace Application\Helper\Repository;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorAwareInterface;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use RuntimeException;

class Extracter
{
    public static function extractValues(
        PreparableSqlInterface $preparableSql,
        AdapterInterface $adapter,
        HydratorAwareInterface $hydratorAwarePrototype,
    ): array {
        $resultSet = self::getResultSet($preparableSql, $adapter, $hydratorAwarePrototype);

        $strategy = new CollectionStrategy(
            $hydratorAwarePrototype->getHydrator(),
            get_class($hydratorAwarePrototype)
        );

        return $strategy->hydrate($resultSet->toArray());
    }

    public static function extractValue(
        PreparableSqlInterface $preparableSql,
        AdapterInterface $adapter,
        HydratorAwareInterface $hydratorAwarePrototype,
    ): ?object {
        $resultSet = self::getResultSet($preparableSql, $adapter, $hydratorAwarePrototype);

        return $resultSet->current();
    }

    private static function getResultSet(
        PreparableSqlInterface $preparableSql,
        AdapterInterface $adapter,
        HydratorAwareInterface $hydratorAwarePrototype,
    ): HydratingResultSet {
        $sql = new Sql($adapter);
        $statement = $sql->prepareStatementForSqlObject($preparableSql);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(
                'Failed retrieving the object; Unknown database error.'
            );
        }

        $resultSet = new HydratingResultSet($hydratorAwarePrototype->getHydrator(), $hydratorAwarePrototype);
        $resultSet->initialize($result);

        return $resultSet;
    }
}
