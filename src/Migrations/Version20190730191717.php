<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730191717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A64B64DCC');
        $this->addSql('DROP INDEX IDX_5F9E962A64B64DCC ON comments');
        $this->addSql('ALTER TABLE comments CHANGE userid user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA76ED395 ON comments (user_id)');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C164B64DCC');
        $this->addSql('DROP INDEX IDX_E1D902C164B64DCC ON tricks');
        $this->addSql('ALTER TABLE tricks CHANGE userid user-id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1F01B6FAB FOREIGN KEY (user-id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C1F01B6FAB ON tricks (user-id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('DROP INDEX IDX_5F9E962AA76ED395 ON comments');
        $this->addSql('ALTER TABLE comments CHANGE user_id userId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A64B64DCC FOREIGN KEY (userId) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A64B64DCC ON comments (userId)');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1F01B6FAB');
        $this->addSql('DROP INDEX IDX_E1D902C1F01B6FAB ON tricks');
        $this->addSql('ALTER TABLE tricks CHANGE user-id userId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C164B64DCC FOREIGN KEY (userId) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_E1D902C164B64DCC ON tricks (userId)');
    }
}
