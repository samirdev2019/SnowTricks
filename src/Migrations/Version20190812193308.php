<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812193308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, user_id INT NOT NULL, content LONGTEXT NOT NULL, commented_at DATETIME NOT NULL, INDEX IDX_5F9E962AB281BE2E (trick_id), INDEX IDX_5F9E962AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE illustrations (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_830A942DB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tricks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_E1D902C15E237E06 (name), INDEX IDX_E1D902C1A76ED395 (user_id), INDEX IDX_E1D902C112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, token VARCHAR(255) NOT NULL, is_validated TINYINT(1) DEFAULT NULL, avatar VARCHAR(255) NOT NULL, subscribed_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, platform VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_29AA6432B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tricks ADD CONSTRAINT FK_E1D902C112469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432B281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C112469DE2');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB281BE2E');
        $this->addSql('ALTER TABLE illustrations DROP FOREIGN KEY FK_830A942DB281BE2E');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA6432B281BE2E');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE tricks DROP FOREIGN KEY FK_E1D902C1A76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE illustrations');
        $this->addSql('DROP TABLE tricks');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE videos');
    }
}
