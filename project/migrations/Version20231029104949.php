<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029104949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dashboard (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5C94FFF8B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dashboard_user (dashboard_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9AE3B94BB9D04D2B (dashboard_id), INDEX IDX_9AE3B94BA76ED395 (user_id), PRIMARY KEY(dashboard_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dashboard ADD CONSTRAINT FK_5C94FFF8B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dashboard_user ADD CONSTRAINT FK_9AE3B94BB9D04D2B FOREIGN KEY (dashboard_id) REFERENCES dashboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dashboard_user ADD CONSTRAINT FK_9AE3B94BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dashboard DROP FOREIGN KEY FK_5C94FFF8B03A8386');
        $this->addSql('ALTER TABLE dashboard_user DROP FOREIGN KEY FK_9AE3B94BB9D04D2B');
        $this->addSql('ALTER TABLE dashboard_user DROP FOREIGN KEY FK_9AE3B94BA76ED395');
        $this->addSql('DROP TABLE dashboard');
        $this->addSql('DROP TABLE dashboard_user');
    }
}
