<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190425151412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_option_user (user_option_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_CC86B53FA724908B (user_option_id), INDEX IDX_CC86B53FA76ED395 (user_id), PRIMARY KEY(user_option_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_option_user ADD CONSTRAINT FK_CC86B53FA724908B FOREIGN KEY (user_option_id) REFERENCES user_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_option_user ADD CONSTRAINT FK_CC86B53FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trip_trip_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trip_trip_option ADD PRIMARY KEY (trip_id, trip_option_id)');
        $this->addSql('ALTER TABLE trip_trip_option RENAME INDEX idx_6a79f852a5bc2e0e TO IDX_41A8FC90A5BC2E0E');
        $this->addSql('ALTER TABLE trip_trip_option RENAME INDEX idx_6a79f852badb5c38 TO IDX_41A8FC90BADB5C38');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_option_user DROP FOREIGN KEY FK_CC86B53FA724908B');
        $this->addSql('DROP TABLE user_option');
        $this->addSql('DROP TABLE user_option_user');
        $this->addSql('ALTER TABLE trip_trip_option DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE trip_trip_option ADD PRIMARY KEY (trip_option_id, trip_id)');
        $this->addSql('ALTER TABLE trip_trip_option RENAME INDEX idx_41a8fc90badb5c38 TO IDX_6A79F852BADB5C38');
        $this->addSql('ALTER TABLE trip_trip_option RENAME INDEX idx_41a8fc90a5bc2e0e TO IDX_6A79F852A5BC2E0E');
    }
}
