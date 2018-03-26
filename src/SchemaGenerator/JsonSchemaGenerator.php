<?php

namespace SchemaGenerator;

use Schema\Schema;
use SchemaManager\SchemaManagerInterface;

class JsonSchemaGenerator implements GeneratorInterface
{
    /** @var SchemaManagerInterface */
    private $schemaManager;
    /** @var string */
    private $outputPath;
    /** @var Schema[] */
    private $schemas;

    public function __construct(SchemaManagerInterface $schemaManager, string $outputPath)
    {
        $this->schemaManager = $schemaManager;
        $this->outputPath = $outputPath;
    }

    public function processTable(string $tableName): void
    {
        $columns = $this->schemaManager->listTableColumns($tableName);

        if (!$columns) {
            throw new \RuntimeException('Columns not found!');
        }

        $schema = new Schema($tableName);

        foreach ($columns as $column) {
            $schema->addColumn($column);
        }

        $this->schemas[] = $schema;
    }

    public function write(): void
    {
        foreach ($this->schemas as $schema) {
            file_put_contents(
                $this->outputPath . '/' . $schema->getTitle() . '.schema.json',
                $schema
            );
        }
    }
}
