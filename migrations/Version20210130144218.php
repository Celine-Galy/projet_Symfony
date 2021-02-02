<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130144218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE constructor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE console ADD constructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE console ADD CONSTRAINT FK_3603CFB62D98BF9 FOREIGN KEY (constructor_id) REFERENCES constructor (id)');
        $this->addSql('CREATE INDEX IDX_3603CFB62D98BF9 ON console (constructor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE console DROP FOREIGN KEY FK_3603CFB62D98BF9');
        $this->addSql('DROP TABLE constructor');
        $this->addSql('DROP INDEX IDX_3603CFB62D98BF9 ON console');
        $this->addSql('ALTER TABLE console DROP constructor_id');
    }
}
