<?php

namespace SchemaManager;

interface SchemaManagerInterface
{
    public function listTableColumns(string $tableName): array;

    /** @return TableInterface[] */
    public function listTables(): array;
}
