<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209114605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response_to (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, response_forum_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_934D9DD4F675F31B (author_id), INDEX IDX_934D9DD49EDA5CAD (response_forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_to ADD CONSTRAINT FK_934D9DD4F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response_to ADD CONSTRAINT FK_934D9DD49EDA5CAD FOREIGN KEY (response_forum_id) REFERENCES response_forum (id)');
        $this->addSql('DROP TABLE message_like');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_like (id INT AUTO_INCREMENT NOT NULL, message_forum_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_5F6DB6AA76ED395 (user_id), INDEX IDX_5F6DB6A20EA7EC1 (message_forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE message_like ADD CONSTRAINT FK_5F6DB6A20EA7EC1 FOREIGN KEY (message_forum_id) REFERENCES message_forum (id)');
        $this->addSql('ALTER TABLE message_like ADD CONSTRAINT FK_5F6DB6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE response_to');
    }
}
