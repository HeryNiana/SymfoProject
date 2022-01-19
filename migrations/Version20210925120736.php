<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925120736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blinderie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, sexe VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie1 (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, categorie1_id_id INT NOT NULL, femmeid_id INT NOT NULL, codech VARCHAR(255) NOT NULL, prixjournalier INT NOT NULL, statut VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, capacite VARCHAR(255) NOT NULL, state_menage VARCHAR(255) NOT NULL, heure_menage VARCHAR(255) DEFAULT NULL, INDEX IDX_C509E4FFA8D3EF4A (categorie1_id_id), INDEX IDX_C509E4FF6957B746 (femmeid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, civil VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, national VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dateday (id INT AUTO_INCREMENT NOT NULL, daytoday VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE femme_chambre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heberge (id INT AUTO_INCREMENT NOT NULL, numcli_id INT NOT NULL, numchambre_id INT NOT NULL, dateentre DATE NOT NULL, nbjours VARCHAR(255) NOT NULL, compagne VARCHAR(255) NOT NULL, montant VARCHAR(255) NOT NULL, datesortie DATE NOT NULL, statut VARCHAR(255) NOT NULL, payement VARCHAR(255) NOT NULL, INDEX IDX_D217B48071F5BF5A (numcli_id), INDEX IDX_D217B480A455AA95 (numchambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pucture (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFA8D3EF4A FOREIGN KEY (categorie1_id_id) REFERENCES categorie1 (id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF6957B746 FOREIGN KEY (femmeid_id) REFERENCES femme_chambre (id)');
        $this->addSql('ALTER TABLE heberge ADD CONSTRAINT FK_D217B48071F5BF5A FOREIGN KEY (numcli_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE heberge ADD CONSTRAINT FK_D217B480A455AA95 FOREIGN KEY (numchambre_id) REFERENCES chambre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFA8D3EF4A');
        $this->addSql('ALTER TABLE heberge DROP FOREIGN KEY FK_D217B480A455AA95');
        $this->addSql('ALTER TABLE heberge DROP FOREIGN KEY FK_D217B48071F5BF5A');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF6957B746');
        $this->addSql('DROP TABLE blinderie');
        $this->addSql('DROP TABLE categorie1');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE dateday');
        $this->addSql('DROP TABLE femme_chambre');
        $this->addSql('DROP TABLE heberge');
        $this->addSql('DROP TABLE pucture');
        $this->addSql('DROP TABLE user');
    }
}
