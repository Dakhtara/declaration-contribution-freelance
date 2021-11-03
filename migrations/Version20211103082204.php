<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103082204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_transaction ADD COLUMN label VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_E80D2E5D2BD2236D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__splitted_transaction AS SELECT id, app_transaction, date, amount, counted FROM splitted_transaction');
        $this->addSql('DROP TABLE splitted_transaction');
        $this->addSql('CREATE TABLE splitted_transaction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, app_transaction INTEGER NOT NULL, date DATETIME NOT NULL, amount INTEGER NOT NULL, counted BOOLEAN DEFAULT NULL, CONSTRAINT FK_E80D2E5D2BD2236D FOREIGN KEY (app_transaction) REFERENCES app_transaction (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO splitted_transaction (id, app_transaction, date, amount, counted) SELECT id, app_transaction, date, amount, counted FROM __temp__splitted_transaction');
        $this->addSql('DROP TABLE __temp__splitted_transaction');
        $this->addSql('CREATE INDEX IDX_E80D2E5D2BD2236D ON splitted_transaction (app_transaction)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_transaction AS SELECT id, type, price, datetime, slices FROM app_transaction');
        $this->addSql('DROP TABLE app_transaction');
        $this->addSql('CREATE TABLE app_transaction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(30) NOT NULL, price INTEGER NOT NULL, datetime DATETIME NOT NULL, slices INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO app_transaction (id, type, price, datetime, slices) SELECT id, type, price, datetime, slices FROM __temp__app_transaction');
        $this->addSql('DROP TABLE __temp__app_transaction');
        $this->addSql('DROP INDEX IDX_E80D2E5D2BD2236D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__splitted_transaction AS SELECT id, app_transaction, date, amount, counted FROM splitted_transaction');
        $this->addSql('DROP TABLE splitted_transaction');
        $this->addSql('CREATE TABLE splitted_transaction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, app_transaction INTEGER NOT NULL, date DATETIME NOT NULL, amount INTEGER NOT NULL, counted BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO splitted_transaction (id, app_transaction, date, amount, counted) SELECT id, app_transaction, date, amount, counted FROM __temp__splitted_transaction');
        $this->addSql('DROP TABLE __temp__splitted_transaction');
        $this->addSql('CREATE INDEX IDX_E80D2E5D2BD2236D ON splitted_transaction (app_transaction)');
    }
}
