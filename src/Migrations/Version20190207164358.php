<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190207164358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip ADD traveller_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE58489A0 FOREIGN KEY (traveller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7656F53B12469DE2 ON trip (category_id)');
        $this->addSql('CREATE INDEX IDX_7656F53BE58489A0 ON trip (traveller_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B12469DE2');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BE58489A0');
        $this->addSql('DROP INDEX IDX_7656F53B12469DE2 ON trip');
        $this->addSql('DROP INDEX IDX_7656F53BE58489A0 ON trip');
        $this->addSql('ALTER TABLE trip DROP traveller_id');
    }
}
