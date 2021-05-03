<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210503000433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture ADD couleur VARCHAR(30) NOT NULL, ADD carburant VARCHAR(30) NOT NULL, ADD disponibilité VARCHAR(30) NOT NULL, ADD description VARCHAR(30) NOT NULL, ADD nbrplace INT NOT NULL, ADD datemiseencirculation VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP couleur, DROP carburant, DROP disponibilité, DROP description, DROP nbrplace, DROP datemiseencirculation');
    }
}
