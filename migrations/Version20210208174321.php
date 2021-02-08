<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208174321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, author_initial_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3E7B0BFBF675F31B (author_id), INDEX IDX_3E7B0BFBAC0A7A1F (author_initial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBAC0A7A1F FOREIGN KEY (author_initial_id) REFERENCES message_forum (id)');
        $this->addSql('ALTER TABLE message_forum ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_forum ADD CONSTRAINT FK_7A8D4126F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7A8D4126F675F31B ON message_forum (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE response');
        $this->addSql('ALTER TABLE message_forum DROP FOREIGN KEY FK_7A8D4126F675F31B');
        $this->addSql('DROP INDEX IDX_7A8D4126F675F31B ON message_forum');
        $this->addSql('ALTER TABLE message_forum DROP author_id');
    }
}
