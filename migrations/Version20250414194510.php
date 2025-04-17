<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414194510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__scoreline AS SELECT id FROM scoreline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scoreline
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scoreline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, competitor_id INTEGER NOT NULL, aircraft_id INTEGER NOT NULL, firstnote INTEGER DEFAULT NULL, secondscore INTEGER DEFAULT NULL, thirdnote INTEGER DEFAULT NULL, savingnote INTEGER DEFAULT NULL, replacingnote INTEGER DEFAULT NULL, CONSTRAINT FK_EBD54FF778A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EBD54FF7846E2F5C FOREIGN KEY (aircraft_id) REFERENCES aircraft (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO scoreline (id) SELECT id FROM __temp__scoreline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__scoreline
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EBD54FF778A5D405 ON scoreline (competitor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EBD54FF7846E2F5C ON scoreline (aircraft_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__scoreline AS SELECT id FROM scoreline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scoreline
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scoreline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO scoreline (id) SELECT id FROM __temp__scoreline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__scoreline
        SQL);
    }
}
