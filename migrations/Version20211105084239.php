<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105084239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE app_transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE splitted_transaction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_transaction (id INT NOT NULL, type VARCHAR(30) NOT NULL, label VARCHAR(255) NOT NULL, price INT NOT NULL, datetime TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, slices INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE splitted_transaction (id INT NOT NULL, app_transaction INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount INT NOT NULL, counted BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E80D2E5D2BD2236D ON splitted_transaction (app_transaction)');
        $this->addSql('ALTER TABLE splitted_transaction ADD CONSTRAINT FK_E80D2E5D2BD2236D FOREIGN KEY (app_transaction) REFERENCES app_transaction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE splitted_transaction DROP CONSTRAINT FK_E80D2E5D2BD2236D');
        $this->addSql('DROP SEQUENCE app_transaction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE splitted_transaction_id_seq CASCADE');
        $this->addSql('DROP TABLE app_transaction');
        $this->addSql('DROP TABLE splitted_transaction');
    }
}
