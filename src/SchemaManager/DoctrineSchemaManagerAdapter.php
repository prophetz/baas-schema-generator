<?php

namespace SchemaManager;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;

class DoctrineSchemaManagerAdapter implements SchemaManagerInterface
{
    /** @var AbstractSchemaManager */
    private $schemaManager;

    public function __construct(AbstractSchemaManager $schemaManager)
    {
        $schemaManager->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $this->schemaManager = $schemaManager;
    }

    public function listTableColumns(string $tableName): array
    {
        return $this->schemaManager->listTableColumns($tableName);
    }

    /**
     * @return Table[]
     */
    public function listTables(): array
    {
        return $this->schemaManager->listTables();
    }
}
