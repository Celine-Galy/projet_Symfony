<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208172425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion_user DROP FOREIGN KEY FK_A8FD7A7F1ADED311');
        $this->addSql('ALTER TABLE message_forum_discussion DROP FOREIGN KEY FK_16294A3D1ADED311');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE discussion_user');
        $this->addSql('DROP TABLE message_forum_discussion');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE discussion_user (discussion_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A8FD7A7F1ADED311 (discussion_id), INDEX IDX_A8FD7A7FA76ED395 (user_id), PRIMARY KEY(discussion_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE message_forum_discussion (message_forum_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_16294A3D20EA7EC1 (message_forum_id), INDEX IDX_16294A3D1ADED311 (discussion_id), PRIMARY KEY(message_forum_id, discussion_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE discussion_user ADD CONSTRAINT FK_A8FD7A7F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion_user ADD CONSTRAINT FK_A8FD7A7FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_forum_discussion ADD CONSTRAINT FK_16294A3D1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_forum_discussion ADD CONSTRAINT FK_16294A3D20EA7EC1 FOREIGN KEY (message_forum_id) REFERENCES message_forum (id) ON DELETE CASCADE');
    }
}
