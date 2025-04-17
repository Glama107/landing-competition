<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414194126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE aircraft (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model VARCHAR(255) NOT NULL, registration VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE competitor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_E0D53BAAB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E0D53BAAB03A8386 ON competitor (created_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scoreline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE aircraft
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competitor
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scoreline
        SQL);
    }
}
