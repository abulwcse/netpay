<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200201000923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE filesystem (id INT AUTO_INCREMENT NOT NULL, parent_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E9F64D20B3750AF4 (parent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filesystem ADD CONSTRAINT FK_E9F64D20B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES filesystem (id) ON UPDATE CASCADE ON DELETE RESTRICT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE filesystem DROP FOREIGN KEY FK_E9F64D20B3750AF4');
        $this->addSql('DROP TABLE filesystem');
    }
}
