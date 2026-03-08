<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260308200523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, numero_serie VARCHAR(100) NOT NULL, couleur VARCHAR(50) NOT NULL, statut VARCHAR(50) NOT NULL, photo VARCHAR(255) DEFAULT NULL, is_stock TINYINT NOT NULL, lot_id INT NOT NULL, remplace_par_id INT DEFAULT NULL, INDEX IDX_FEF0481DA8CBA5F7 (lot_id), UNIQUE INDEX UNIQ_FEF0481DA7377412 (remplace_par_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE batiment (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nb_etages INT NOT NULL, a_ascenseur TINYINT NOT NULL, ref_ascenseur VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, copropriete_id INT NOT NULL, INDEX IDX_F5FAB00C6B07769E (copropriete_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE copropriete (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ref_dossier VARCHAR(50) NOT NULL, adresse LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, closed_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, etage INT DEFAULT NULL, porte VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, batiment_id INT NOT NULL, proprietaire_id INT NOT NULL, INDEX IDX_B81291BD6F6891B (batiment_id), INDEX IDX_B81291B76C50E4A (proprietaire_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stock_badge (id INT AUTO_INCREMENT NOT NULL, couleur VARCHAR(50) NOT NULL, quantite INT NOT NULL, seuil_alerte INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, status VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481DA7377412 FOREIGN KEY (remplace_par_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE batiment ADD CONSTRAINT FK_F5FAB00C6B07769E FOREIGN KEY (copropriete_id) REFERENCES copropriete (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BD6F6891B FOREIGN KEY (batiment_id) REFERENCES batiment (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481DA8CBA5F7');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481DA7377412');
        $this->addSql('ALTER TABLE batiment DROP FOREIGN KEY FK_F5FAB00C6B07769E');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BD6F6891B');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B76C50E4A');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE batiment');
        $this->addSql('DROP TABLE copropriete');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE stock_badge');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
