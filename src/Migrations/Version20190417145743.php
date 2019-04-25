<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417145743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ad_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad_option_ad (ad_option_id INT NOT NULL, ad_id INT NOT NULL, INDEX IDX_E9245DBE21FDD7B6 (ad_option_id), INDEX IDX_E9245DBE4F34D596 (ad_id), PRIMARY KEY(ad_option_id, ad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad_option_ad ADD CONSTRAINT FK_E9245DBE21FDD7B6 FOREIGN KEY (ad_option_id) REFERENCES ad_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad_option_ad ADD CONSTRAINT FK_E9245DBE4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad_option_ad DROP FOREIGN KEY FK_E9245DBE21FDD7B6');
        $this->addSql('DROP TABLE ad_option');
        $this->addSql('DROP TABLE ad_option_ad');
    }
}
