<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103212008 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stamp_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stamp_family_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stamp (id INT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_554E9F08C35E566A ON stamp (family_id)');
        $this->addSql('CREATE TABLE stamp_family (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price DOUBLE PRECISION DEFAULT NULL, is_closed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction_stamp (transaction_id INT NOT NULL, stamp_id INT NOT NULL, PRIMARY KEY(transaction_id, stamp_id))');
        $this->addSql('CREATE INDEX IDX_F47D4F482FC0CB0F ON transaction_stamp (transaction_id)');
        $this->addSql('CREATE INDEX IDX_F47D4F48FEF6E9F ON transaction_stamp (stamp_id)');
        $this->addSql('ALTER TABLE stamp ADD CONSTRAINT FK_554E9F08C35E566A FOREIGN KEY (family_id) REFERENCES stamp_family (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction_stamp ADD CONSTRAINT FK_F47D4F482FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction_stamp ADD CONSTRAINT FK_F47D4F48FEF6E9F FOREIGN KEY (stamp_id) REFERENCES stamp (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transaction_stamp DROP CONSTRAINT FK_F47D4F48FEF6E9F');
        $this->addSql('ALTER TABLE stamp DROP CONSTRAINT FK_554E9F08C35E566A');
        $this->addSql('ALTER TABLE transaction_stamp DROP CONSTRAINT FK_F47D4F482FC0CB0F');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stamp_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stamp_family_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transaction_id_seq CASCADE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE stamp');
        $this->addSql('DROP TABLE stamp_family');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_stamp');
    }
}
