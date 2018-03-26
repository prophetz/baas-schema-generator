<?php

namespace Schema;

use Camspiers\JsonPretty\JsonPretty;
use Doctrine\DBAL\Schema\Column;

class Schema
{
    private const VERSION = '1.0';

    /** @var array */
    private $schema;
    /** @var string */
    private $title;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->schema = [
            'version' => self::VERSION,
            'title' => $title,
            'type' => 'object',
            'properties' => [],
            'required' => []
        ];
    }

    /**
     * @param Column $column
     * @throws \RuntimeException
     */
    public function addColumn(Column $column): void
    {
        $this->addColumnProperties($column);

        if ($column->getNotnull()) {
            $this->addColumnToRequired($column);
        }
    }

    /**
     * @param $doctrineType
     * @return string
     * @throws \RuntimeException
     */
    private function mapType($doctrineType): string
    {
        return strtolower($doctrineType);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (new JsonPretty)->prettify($this->schema);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param Column $column
     * @throws \RuntimeException
     */
    private function addColumnProperties(Column $column): void
    {
        $properties = [
            'type' => $this->mapType($column->getType())
        ];

        $this->schema['properties'][$column->getName()] = $properties;
    }

    /**
     * @param Column $column
     */
    private function addColumnToRequired(Column $column): void
    {
        $this->schema['required'][] = $column->getName();
    }

}
