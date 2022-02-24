<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224132440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FAE31E4D FOREIGN KEY (produit_p_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27FAE31E4D ON produit (produit_p_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FAE31E4D');
        $this->addSql('DROP INDEX IDX_29A5EC27FAE31E4D ON produit');
    }
}
