<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210502230903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9181A8BA');
        $this->addSql('DROP INDEX IDX_64C19AA9181A8BA ON agence');
        $this->addSql('ALTER TABLE agence DROP voiture_id, DROP adresseville');
        $this->addSql('DROP INDEX UNIQ_E9E2810F12B2DC9C ON voiture');
        $this->addSql('ALTER TABLE voiture DROP nbrplace, DROP couleur, DROP carburant, DROP disponibilit, DROP description, DROP datemiseencirculation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD voiture_id INT DEFAULT NULL, ADD adresseville VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_64C19AA9181A8BA ON agence (voiture_id)');
        $this->addSql('ALTER TABLE voiture ADD nbrplace INT NOT NULL, ADD couleur VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD carburant VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD disponibilit VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD datemiseencirculation VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F12B2DC9C ON voiture (matricule)');
    }
}
