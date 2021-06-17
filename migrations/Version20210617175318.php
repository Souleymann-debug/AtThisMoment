<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617175318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD rubrique_id INT DEFAULT NULL, ADD a_la_une TINYINT(1) NOT NULL, DROP rubrique, CHANGE contenu contenu TEXT NOT NULL, CHANGE date_poste date_poste DATETIME NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663BD38833 FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_23A0E663BD38833 ON article (rubrique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E663BD38833');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP INDEX IDX_23A0E663BD38833 ON article');
        $this->addSql('ALTER TABLE article ADD rubrique VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP rubrique_id, DROP a_la_une, CHANGE contenu contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_poste date_poste DATE NOT NULL');
    }
}
