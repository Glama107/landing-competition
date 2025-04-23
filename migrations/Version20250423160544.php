<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423160544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline ADD is_firstnote_stop_app TINYINT(1) DEFAULT NULL, ADD is_secondnote_stop_app TINYINT(1) DEFAULT NULL, ADD is_thirdnote_stop_app TINYINT(1) DEFAULT NULL, ADD is_replacingscore_stop_app TINYINT(1) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline DROP is_firstnote_stop_app, DROP is_secondnote_stop_app, DROP is_thirdnote_stop_app, DROP is_replacingscore_stop_app
        SQL);
    }
}
