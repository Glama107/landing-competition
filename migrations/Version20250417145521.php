<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417145521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE aircraft (id INT AUTO_INCREMENT NOT NULL, model VARCHAR(255) NOT NULL, registration VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE competitor (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E0D53BAAB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scoreline (id INT AUTO_INCREMENT NOT NULL, competitor_id INT NOT NULL, aircraft_id INT NOT NULL, firstnote INT DEFAULT NULL, secondscore INT DEFAULT NULL, thirdnote INT DEFAULT NULL, savingnote INT DEFAULT NULL, replacingnote INT DEFAULT NULL, INDEX IDX_EBD54FF778A5D405 (competitor_id), INDEX IDX_EBD54FF7846E2F5C (aircraft_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competitor ADD CONSTRAINT FK_E0D53BAAB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline ADD CONSTRAINT FK_EBD54FF778A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline ADD CONSTRAINT FK_EBD54FF7846E2F5C FOREIGN KEY (aircraft_id) REFERENCES aircraft (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE competitor DROP FOREIGN KEY FK_E0D53BAAB03A8386
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline DROP FOREIGN KEY FK_EBD54FF778A5D405
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scoreline DROP FOREIGN KEY FK_EBD54FF7846E2F5C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE aircraft
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competitor
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scoreline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
