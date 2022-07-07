<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627131411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE check_url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE check_url (id INT NOT NULL, url_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, code INT NOT NULL, repeat_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A1BCC96381CFDAE7 ON check_url (url_id)');
        $this->addSql('COMMENT ON COLUMN check_url.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE url (id INT NOT NULL, url VARCHAR(255) NOT NULL, frequency INT NOT NULL, quantity_repeated INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN url.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE check_url ADD CONSTRAINT FK_A1BCC96381CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE check_url DROP CONSTRAINT FK_A1BCC96381CFDAE7');
        $this->addSql('DROP SEQUENCE check_url_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE url_id_seq CASCADE');
        $this->addSql('DROP TABLE check_url');
        $this->addSql('DROP TABLE url');
    }
}
