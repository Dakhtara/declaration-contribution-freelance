<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028113202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE splitted_transaction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "transaction" INTEGER NOT NULL, date DATETIME NOT NULL, amount INTEGER NOT NULL, counted BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_E80D2E5D723705D1 ON splitted_transaction ("transaction")');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(30) NOT NULL, price INTEGER NOT NULL, datetime DATETIME NOT NULL, slices INTEGER DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE splitted_transaction');
        $this->addSql('DROP TABLE "transaction"');
    }
}
