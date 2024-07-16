<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706141659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bon_de_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, date DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, qantite INT NOT NULL, nom_comercial VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_2C3802E4F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bon_de_commande ADD CONSTRAINT FK_2C3802E4F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bon_de_commande DROP FOREIGN KEY FK_2C3802E4F347EFB');
        $this->addSql('DROP TABLE bon_de_commande');
    }
}
