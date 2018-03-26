<?php

namespace SchemaGenerator;

use SchemaManager\SchemaManagerInterface;

interface GeneratorInterface
{
    public function __construct(SchemaManagerInterface $schemaManager, string $outputPath);

    public function processTable(string $tableName): void;

    public function write(): void;
}
