<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190425111044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE trip_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip_option_trip (trip_option_id INT NOT NULL, trip_id INT NOT NULL, INDEX IDX_6A79F852BADB5C38 (trip_option_id), INDEX IDX_6A79F852A5BC2E0E (trip_id), PRIMARY KEY(trip_option_id, trip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trip_option_trip ADD CONSTRAINT FK_6A79F852BADB5C38 FOREIGN KEY (trip_option_id) REFERENCES trip_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip_option_trip ADD CONSTRAINT FK_6A79F852A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip_option_trip DROP FOREIGN KEY FK_6A79F852BADB5C38');
        $this->addSql('DROP TABLE trip_option');
        $this->addSql('DROP TABLE trip_option_trip');
    }
}
