<?php

namespace Command;

use Connection\DoctrineConnection;
use SchemaGenerator\JsonSchemaGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SchemaGenerationCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('schema:generate')
            ->setDescription('Generate schema.json file from existing database table')
            ->addArgument(
                'dsn',
                InputArgument::REQUIRED,
                'DSN'
            )
            ->addOption(
                'tableName',
                null,
                InputOption::VALUE_OPTIONAL,
                'Table Name'
            )
            ->addOption(
                'outputPath',
                null,
                InputOption::VALUE_REQUIRED,
                'Path for output schema.json file',
                '.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = new DoctrineConnection($input->getArgument('dsn'));

        $schemaManager = $connection->getSchemaManager();

        $tableName = $input->getOption('tableName');
        $outputPath = $input->getOption('outputPath');

        $tables = $schemaManager->listTables();

        if (!$tables && !$tableName) {
            throw new \RuntimeException('Tables not found');
        }

        $schemaGenerator = new JsonSchemaGenerator($schemaManager, $outputPath);

        if ($tableName) {
            $schemaGenerator->processTable($tableName);
        } else {
            try {
                foreach ($tables as $table) {
                    $schemaGenerator->processTable($table->getName());
                }
            } catch (\Exception $e) {
                $output->writeln('Error with table ' . $table->getName() . ': ' . $e->getMessage());
                throw  $e;
            }
        }

        $schemaGenerator->write();

        $output->writeln('Schema generated successfully!');
    }
}
