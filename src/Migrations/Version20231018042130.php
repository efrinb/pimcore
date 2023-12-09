<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018042130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('customtable');
        $table->addColumn('username', 'string');
        $table->addColumn('password', 'string');

        $table = $schema->createTable('votes');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->setPrimaryKey(['id']);
        $table->addColumn('username', 'string');
        $table->addColumn('score', 'integer');

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('customtable');

        $schema->dropTable('votes');
    }
}
