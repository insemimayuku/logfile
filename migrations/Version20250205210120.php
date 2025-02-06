<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20250121223148.php
final class Version20250121223148 extends AbstractMigration
========
final class Version20250205210120 extends AbstractMigration
>>>>>>>> 09f404c2baae1690481692a21b56e66768420c0b:migrations/Version20250205210120.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20250121223148.php
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, thumdnail VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, size DOUBLE PRECISION DEFAULT NULL, date_upload DATE NOT NULL, extension VARCHAR(255) NOT NULL, archiver TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storage_corps (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size_allow DOUBLE PRECISION NOT NULL, size_use DOUBLE PRECISION NOT NULL, date_created DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
========
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL');
>>>>>>>> 09f404c2baae1690481692a21b56e66768420c0b:migrations/Version20250205210120.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20250121223148.php
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE storage_corps');
        $this->addSql('DROP TABLE `user`');
========
        $this->addSql('ALTER TABLE `user` DROP first_name, DROP last_name');
>>>>>>>> 09f404c2baae1690481692a21b56e66768420c0b:migrations/Version20250205210120.php
    }
}
