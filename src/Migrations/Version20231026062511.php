<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026062511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('admin_log_activities');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->setPrimaryKey(['id']);
        $table->addColumn('timestamp', 'datetime');
        $table->addColumn('log_level', 'string', ['length' => 255]);
        $table->addColumn('action', 'string', ['length' => 255]);
        $table->addColumn('controller', 'text', ['notnull' => false]);
        $table->addColumn('request_data', 'json', ['notnull' => false]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('admin_log_activities');
    }
}
