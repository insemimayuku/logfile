<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260118194943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, thumdnail VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, size DOUBLE PRECISION DEFAULT NULL, date_upload DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', extension VARCHAR(255) NOT NULL, archiver TINYINT(1) DEFAULT NULL, INDEX IDX_8C9F361079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage_corps (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size_allow DOUBLE PRECISION NOT NULL, size_use DOUBLE PRECISION NOT NULL, date_created DATE NOT NULL, path VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, storage_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_8D93D6495CC5DB90 (storage_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361079F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6495CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage_corps (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361079F37AE5');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6495CC5DB90');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE storage_corps');
        $this->addSql('DROP TABLE `user`');
    }
}
