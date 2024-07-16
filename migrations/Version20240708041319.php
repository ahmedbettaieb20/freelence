<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708041319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bon_de_commande_user DROP FOREIGN KEY FK_B4A2D040A76ED395');
        $this->addSql('ALTER TABLE bon_de_commande_user DROP FOREIGN KEY FK_B4A2D040D29E677C');
        $this->addSql('DROP TABLE bon_de_commande_user');
        $this->addSql('ALTER TABLE bon_de_commande ADD nom_comercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bon_de_commande ADD CONSTRAINT FK_2C3802E46F6CA87F FOREIGN KEY (nom_comercial_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2C3802E46F6CA87F ON bon_de_commande (nom_comercial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bon_de_commande_user (bon_de_commande_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4A2D040D29E677C (bon_de_commande_id), INDEX IDX_B4A2D040A76ED395 (user_id), PRIMARY KEY(bon_de_commande_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bon_de_commande_user ADD CONSTRAINT FK_B4A2D040A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bon_de_commande_user ADD CONSTRAINT FK_B4A2D040D29E677C FOREIGN KEY (bon_de_commande_id) REFERENCES bon_de_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bon_de_commande DROP FOREIGN KEY FK_2C3802E46F6CA87F');
        $this->addSql('DROP INDEX IDX_2C3802E46F6CA87F ON bon_de_commande');
        $this->addSql('ALTER TABLE bon_de_commande DROP nom_comercial_id');
    }
}
