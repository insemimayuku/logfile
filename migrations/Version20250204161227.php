<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204161227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD storage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage_corps (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495CC5DB90 ON user (storage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6495CC5DB90');
        $this->addSql('DROP INDEX IDX_8D93D6495CC5DB90 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP storage_id');
    }
}
