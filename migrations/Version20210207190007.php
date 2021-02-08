<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210207190007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_forum_discussion (message_forum_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_16294A3D20EA7EC1 (message_forum_id), INDEX IDX_16294A3D1ADED311 (discussion_id), PRIMARY KEY(message_forum_id, discussion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_forum_discussion ADD CONSTRAINT FK_16294A3D20EA7EC1 FOREIGN KEY (message_forum_id) REFERENCES message_forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_forum_discussion ADD CONSTRAINT FK_16294A3D1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE message_forum_discussion');
    }
}
