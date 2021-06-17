<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616145339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postlike DROP FOREIGN KEY FK_B84FD43A4B89032C');
        $this->addSql('DROP INDEX IDX_B84FD43A4B89032C ON postlike');
        $this->addSql('ALTER TABLE postlike CHANGE post_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postlike ADD CONSTRAINT FK_B84FD43A7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_B84FD43A7294869C ON postlike (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postlike DROP FOREIGN KEY FK_B84FD43A7294869C');
        $this->addSql('DROP INDEX IDX_B84FD43A7294869C ON postlike');
        $this->addSql('ALTER TABLE postlike CHANGE article_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postlike ADD CONSTRAINT FK_B84FD43A4B89032C FOREIGN KEY (post_id) REFERENCES postlike (id)');
        $this->addSql('CREATE INDEX IDX_B84FD43A4B89032C ON postlike (post_id)');
    }
}
