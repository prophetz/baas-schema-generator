<?php

namespace Connection;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;
use SchemaManager\DoctrineSchemaManagerAdapter;
use SchemaManager\SchemaManagerInterface;

class DoctrineConnection implements ConnectionInterface
{
    /** @var Connection */
    private $connection;

    public function __construct(string $dsn)
    {
        $this->connection = DriverManager::getConnection(['url' => $dsn], new Configuration());
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getSchemaManager(): SchemaManagerInterface
    {
        return new DoctrineSchemaManagerAdapter($this->connection->getSchemaManager());
    }
}
