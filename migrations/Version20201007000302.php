<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007000302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code ADD COLUMN created_at DATETIME NULL');
        $this->addSql('ALTER TABLE code ADD COLUMN updated_at DATETIME NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__code AS SELECT id, phone_number, verification_code, used FROM code');
        $this->addSql('DROP TABLE code');
        $this->addSql('CREATE TABLE code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, phone_number INTEGER NOT NULL, verification_code VARCHAR(4) NOT NULL, used BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO code (id, phone_number, verification_code, used) SELECT id, phone_number, verification_code, used FROM __temp__code');
        $this->addSql('DROP TABLE __temp__code');
    }
}
