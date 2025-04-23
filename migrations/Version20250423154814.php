<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423154814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline ADD judge_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline ADD CONSTRAINT FK_EBD54FF7B7D66194 FOREIGN KEY (judge_id) REFERENCES judge (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EBD54FF7B7D66194 ON scoreline (judge_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline DROP FOREIGN KEY FK_EBD54FF7B7D66194
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_EBD54FF7B7D66194 ON scoreline
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline DROP judge_id
        SQL);
    }
}
