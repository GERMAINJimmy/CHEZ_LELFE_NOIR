<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521151527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(50) NOT NULL, titre VARCHAR(50) NOT NULL, duree INT NOT NULL, place INT NOT NULL, public VARCHAR(6) NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, slug VARCHAR(128) NOT NULL, date_enregistrement DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_E1BB1823989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, atelier_id INT NOT NULL, INDEX IDX_99D848C1BCF5E72D (categorie_id), INDEX IDX_99D848C182E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, atelier_id INT NOT NULL, participant INT NOT NULL, INDEX IDX_AB62A49882EA2E54 (commande_id), INDEX IDX_AB62A49882E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, etat VARCHAR(10) NOT NULL, date_enregistrement DATETIME NOT NULL, date_modification DATETIME NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, note INT NOT NULL, message LONGTEXT NOT NULL, date_enregistrement DATETIME NOT NULL, date_modification DATETIME NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(50) NOT NULL, titre VARCHAR(50) NOT NULL, couleur VARCHAR(50) NOT NULL, public VARCHAR(6) NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, stock INT NOT NULL, taille VARCHAR(5) NOT NULL, slug VARCHAR(128) NOT NULL, date_enregistrement DATETIME NOT NULL, date_modification DATETIME NOT NULL, UNIQUE INDEX UNIQ_29A5EC27989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, sous_categorie_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_CDEA88D8BCF5E72D (categorie_id), INDEX IDX_CDEA88D8365BF48 (sous_categorie_id), INDEX IDX_CDEA88D8F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_commande (id INT AUTO_INCREMENT NOT NULL, commmande_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_47F5946EC39BA5D5 (commmande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_commande_produit (produit_commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_2C87E10FFCF26AD0 (produit_commande_id), INDEX IDX_2C87E10FF347EFB (produit_id), PRIMARY KEY(produit_commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, date_enregistrement DATETIME NOT NULL, date_modification DATETIME NOT NULL, INDEX IDX_C11D7DD1F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(100) NOT NULL, INDEX IDX_52743D7BBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, civilite VARCHAR(10) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(20) NOT NULL, adresse VARCHAR(100) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(100) NOT NULL, date_enregistrement DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier_categorie ADD CONSTRAINT FK_99D848C1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE atelier_categorie ADD CONSTRAINT FK_99D848C182E2CF35 FOREIGN KEY (atelier_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE atelier_commande ADD CONSTRAINT FK_AB62A49882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE atelier_commande ADD CONSTRAINT FK_AB62A49882E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_CDEA88D8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EC39BA5D5 FOREIGN KEY (commmande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit_commande_produit ADD CONSTRAINT FK_2C87E10FFCF26AD0 FOREIGN KEY (produit_commande_id) REFERENCES produit_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_commande_produit ADD CONSTRAINT FK_2C87E10FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier_commande DROP FOREIGN KEY FK_AB62A49882E2CF35');
        $this->addSql('ALTER TABLE atelier_categorie DROP FOREIGN KEY FK_99D848C1BCF5E72D');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8BCF5E72D');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BBCF5E72D');
        $this->addSql('ALTER TABLE atelier_commande DROP FOREIGN KEY FK_AB62A49882EA2E54');
        $this->addSql('ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946EC39BA5D5');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8F347EFB');
        $this->addSql('ALTER TABLE produit_commande_produit DROP FOREIGN KEY FK_2C87E10FF347EFB');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1F347EFB');
        $this->addSql('ALTER TABLE produit_commande_produit DROP FOREIGN KEY FK_2C87E10FFCF26AD0');
        $this->addSql('ALTER TABLE atelier_categorie DROP FOREIGN KEY FK_99D848C182E2CF35');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_CDEA88D8365BF48');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE atelier_categorie');
        $this->addSql('DROP TABLE atelier_commande');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_categorie');
        $this->addSql('DROP TABLE produit_commande');
        $this->addSql('DROP TABLE produit_commande_produit');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('DROP TABLE user');
    }
}
