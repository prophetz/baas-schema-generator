<?php

namespace Connection;

use SchemaManager\SchemaManagerInterface;

interface ConnectionInterface
{
    public function getConnection();

    public function getSchemaManager(): SchemaManagerInterface;
}
