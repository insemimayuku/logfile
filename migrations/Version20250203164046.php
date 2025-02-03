<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203164046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36109D86650F');
        $this->addSql('DROP INDEX IDX_8C9F36109D86650F ON file');
        $this->addSql('ALTER TABLE file ADD user_id INT NOT NULL, ADD upload_date DATETIME NOT NULL, DROP user_id_id, DROP format, DROP date_upload, DROP statut, DROP description, CHANGE size size INT NOT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8C9F3610A76ED395 ON file (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('DROP INDEX IDX_8C9F3610A76ED395 ON file');
        $this->addSql('ALTER TABLE file ADD user_id_id INT DEFAULT NULL, ADD format VARCHAR(50) NOT NULL, ADD date_upload DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD statut VARCHAR(50) DEFAULT \'isactive\' NOT NULL, ADD description LONGTEXT NOT NULL, DROP user_id, DROP upload_date, CHANGE size size BIGINT NOT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8C9F36109D86650F ON file (user_id_id)');
    }
}
