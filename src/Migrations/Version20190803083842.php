<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190803083842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments CHANGE user_id user_id INT DEFAULT NULL, CHANGE commented_at commented_at DATE NOT NULL');
        $this->addSql('ALTER TABLE illustrations DROP FOREIGN KEY FK_830A942DB281BE2E');
        $this->addSql('DROP INDEX IDX_830A942DB281BE2E ON illustrations');
        $this->addSql('ALTER TABLE illustrations DROP trick_id, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD groupe VARCHAR(255) NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE subscribed_at subscribed_at DATE NOT NULL');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA6432B281BE2E');
        $this->addSql('DROP INDEX IDX_29AA6432B281BE2E ON videos');
        $this->addSql('ALTER TABLE videos ADD trickId INT DEFAULT NULL, DROP trick_id');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA643251F6BF91 FOREIGN KEY (trickId) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_29AA643251F6BF91 ON videos (trickId)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments CHANGE user_id user_id INT NOT NULL, CHANGE commented_at commented_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE illustrations ADD trick_id INT NOT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_830A942DB281BE2E ON illustrations (trick_id)');
        $this->addSql('ALTER TABLE tricks DROP groupe, CHANGE user_id user_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE subscribed_at subscribed_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA643251F6BF91');
        $this->addSql('DROP INDEX IDX_29AA643251F6BF91 ON videos');
        $this->addSql('ALTER TABLE videos ADD trick_id INT NOT NULL, DROP trickId');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432B281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_29AA6432B281BE2E ON videos (trick_id)');
    }
}
