<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124154114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_transactions (user_id INT NOT NULL, transaction_id INT NOT NULL, PRIMARY KEY(user_id, transaction_id))');
        $this->addSql('CREATE INDEX IDX_6A64664EA76ED395 ON user_transactions (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A64664E2FC0CB0F ON user_transactions (transaction_id)');
        $this->addSql('ALTER TABLE user_transactions ADD CONSTRAINT FK_6A64664EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_transactions ADD CONSTRAINT FK_6A64664E2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES app_transaction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_transactions');
    }
}
