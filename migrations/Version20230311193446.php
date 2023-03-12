<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230311193446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, type VARCHAR(64) NOT NULL, institute VARCHAR(255) DEFAULT NULL, faculty VARCHAR(150) DEFAULT NULL, specialization VARCHAR(150) DEFAULT NULL, end_year SMALLINT DEFAULT NULL, INDEX IDX_DB0A5ED2D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(64) NOT NULL, first_name VARCHAR(128) NOT NULL, last_name VARCHAR(128) NOT NULL, patronymic VARCHAR(128) DEFAULT NULL, city VARCHAR(128) NOT NULL, profession VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, birthdate DATE NOT NULL, phone VARCHAR(10) NOT NULL, expected_salary INT DEFAULT NULL, skills VARCHAR(512) DEFAULT NULL, experience VARCHAR(2048) DEFAULT NULL, about VARCHAR(2048) DEFAULT NULL, image_preview VARCHAR(1024) DEFAULT NULL, UNIQUE INDEX UNIQ_60C1D0A0444F97DD (phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2D262AF09');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
