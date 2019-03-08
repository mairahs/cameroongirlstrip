<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190301220449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trip_booking (id INT AUTO_INCREMENT NOT NULL, trip_booker_id INT NOT NULL, trip_id INT NOT NULL, number_places INT NOT NULL, created_at DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_D6E0A87396610151 (trip_booker_id), INDEX IDX_D6E0A873A5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip_booking ADD CONSTRAINT FK_D6E0A87396610151 FOREIGN KEY (trip_booker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip_booking ADD CONSTRAINT FK_D6E0A873A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE trip_booking');
    }
}
