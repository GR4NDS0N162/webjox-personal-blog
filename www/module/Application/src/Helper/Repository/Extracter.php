<?php

namespace Application\Helper\Repository;

use InvalidArgumentException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use RuntimeException;
use stdClass;

class Extracter
{
    /**
     * @param PreparableSqlInterface $preparable
     * @param AdapterInterface       $db
     * @param HydratorInterface      $hydrator
     * @param object|null            $prototype
     *
     * @return array|object[]
     */
    public static function extractValues(
        PreparableSqlInterface $preparable,
        AdapterInterface $db,
        HydratorInterface $hydrator,
        object $prototype = null,
    ): array {
        $sql = new Sql($db);
        $statement = $sql->prepareStatementForSqlObject($preparable);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($hydrator, $prototype);
        $resultSet->initialize($result);

        $strategy = new CollectionStrategy(
            $hydrator,
            get_class($prototype) ?: stdClass::class
        );
        return $strategy->hydrate($resultSet->toArray());
    }

    /**
     * @param PreparableSqlInterface $preparable
     * @param AdapterInterface       $db
     * @param HydratorInterface|null $hydrator
     * @param object|null            $prototype
     *
     * @return object
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public static function extractValue(
        PreparableSqlInterface $preparable,
        AdapterInterface $db,
        HydratorInterface $hydrator = null,
        object $prototype = null,
    ): object {
        $sql = new Sql($db);
        $statement = $sql->prepareStatementForSqlObject($preparable);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(
                'Failed retrieving the object; unknown database error.'
            );
        }

        $resultSet = new HydratingResultSet($hydrator, $prototype);
        $resultSet->initialize($result);
        $object = $resultSet->current();

        if (!$object) {
            throw new InvalidArgumentException(
                'Object not found.'
            );
        }

        return $object;
    }
}
