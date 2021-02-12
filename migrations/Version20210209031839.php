<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209031839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response_like (id INT AUTO_INCREMENT NOT NULL, response_forum_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_C24A299EDA5CAD (response_forum_id), INDEX IDX_C24A29A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_like ADD CONSTRAINT FK_C24A299EDA5CAD FOREIGN KEY (response_forum_id) REFERENCES response_forum (id)');
        $this->addSql('ALTER TABLE response_like ADD CONSTRAINT FK_C24A29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE response_like');
    }
}
